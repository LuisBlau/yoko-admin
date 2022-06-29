<?php

namespace App\Http\Controllers;

use App\Services\NsApiHistoryHandler;
use App\Services\NsApiRequests;
use App\Services\ParelessRequests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    private $status = ['sent', 'received'];

    private $type = 'SMS';

    private $platform = ['netspaiens', 'yokoapi', 'pareless'];

    /**
     * @Route("admin/message/send", name="send-ns-message-admin")
     * @param Request $request
     * @param NsApiRequests $apiRequests
     * @param NsApiHistoryHandler $apiHistoryHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function sendMessageFromAdminPanel(
        Request $request,
        NsApiRequests $apiRequests,
        NsApiHistoryHandler $apiHistoryHandler,
        LoggerInterface $logger
    )
    {
        $data = null;

        if (!empty($request) && !empty($request->_csrf_token)) {
            $from = $request->number_from;
            $to = $request->number_to;
            $message = $request->message;

            if (!empty($from) && !empty($to) && !empty($message)) {
                $result = $apiRequests->sendMessage($from, $to, $message);
                $apiHistoryHandler->addMessage($from, $to, $this->type, $message, $this->status[0], $this->platform[1]);

                $data = [
                    'status' => 201,
                    'message' => json_decode($result)
                ];

                $this->addFlash('success', 'Message successfully send!');

                return $this->redirect($request->getUri());
            } else {
                $data = [
                    'status' => 400,
                    'message' => 'Error, please check your form'
                ];
                $this->addFlash('danger', 'Error! Check your form values!');
                return $this->redirect($request->getUri());
            }
        }
        return view('ns_messages')
        ->with('data', $data);
    }

    /**
     * @Route("/messages", name="callback-handler", methods={"POST"})
     * @param Request $request
     * @param LoggerInterface $logger
     * @param NsApiHistoryHandler $apiHistoryHandler
     * @param ParelessRequests $parelessRequests
     * @param NsApiRequests $apiRequests
     * @return void
     */
    public function pbxCallBackHandler (
        Request $request,
        LoggerInterface $logger,
        NsApiHistoryHandler $apiHistoryHandler,
        ParelessRequests $parelessRequests,
        NsApiRequests $apiRequests
    )
    {
        $data = $request->getContent();
        if (!$data) {
            $logger->notice('Failed to get request');
            return response()->json("Request data is missing", 500);

        }
        $dataDecoded = json_decode($data);


        if (!isset($dataDecoded->messages)) {
            $logger->emergency('pareless');
            $logger->emergency($data);
            $this->handleMessagesFromPareless($dataDecoded, $apiHistoryHandler, $apiRequests, $logger);
        } else {
            $logger->emergency('netspaiens');
            $logger->emergency($data);
            $this->handleMessageFromPbx($dataDecoded, $apiHistoryHandler, $parelessRequests, $logger);
        }
        return response()->json("Request handled successfully", 200);
    }

    private function handleMessageFromPbx($data = null, $apiHistoryHandler, $parelessRequests, $logger)
    {
        if (!$data) {
            return response()->json("Could not send request", 500);
        }

        foreach ($data->messages as $item) {
            $destination = [$item->destination_number];
            $apiHistoryHandler->addMessage(
                $item->source_number,
                $item->destination_number,
                $item->format,
                $item->content,
                $this->status[1],
                $this->platform[0]
            );
        }
        $requestResult = $parelessRequests->sendMessage($item->source_number, $destination, $item->content);

        if (!$requestResult) {
            $logger->notice('Could not send message to pareless network enviroment');
        } else {
            $logger->notice('Request result: ' . $requestResult);
        }
    }

    private function handleMessagesFromPareless($data = null, $apiHistoryHandler, $apiRequests, $logger)
    {
        if (!$data) {
            return response()->json("Could not send request", 500);
        }
        foreach ($data->recipients as $recipient) {
            $apiHistoryHandler->addMessage(
                $data->from,
                $recipient,
                $this->type,
                $data->text,
                $this->status[1],
                $this->platform[2]
            );
            $requestResult = $apiRequests->sendMessage($data->from, $recipient, $data->text);
        }
        if (!$requestResult) {
            $logger->notice('Could not send message to pareless network enviroment');
        } else {
            $logger->notice('Request result: ' . $requestResult);
        }
    }
}