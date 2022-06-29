			<!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!--- Divider -->

                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <li class="menu-title">Main</li>
                            <li>
                                <a href="{{ url('/home') }}"  class="waves-effect">
                                    <i class="remixicon-home-3-line"></i><span> Dashboard </span>
                                </a>
                            </li>
							<li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-stack-line"></i><span> Inventory </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-productcategories', 'view'))<li><a href="{{ url('productcategories') }}">Product Categories</a></li>@endif
                                    @if(\Gate::allows('page-product', 'view'))<li><a href="{{ url('product') }}">Products</a></li>@endif
                                    @if(\Gate::allows('page-suppliers', 'view'))<li><a href="{{ url('suppliers') }}">Suppliers</a></li>@endif
                                    @if(\Gate::allows('page-manufacturers', 'view'))<li><a href="{{ url('manufacturers') }}">Manufacturers</a></li>@endif
                                    <li><a href="{{ route('web.warehouseinventory.index') }}">Manage Warehouses</a></li>
                                    @if(\Gate::allows('page-inventorycountpage', 'view'))<li><a href="{{ route('web.inventorycountpage.index') }}">Inventory Count</a></li>@endif
                                    <li><a href="{{ route('web.inventory.reorderreport') }}">Reorder Report</a></li>
                                </ul>

                            </li>
                            @if (Auth::user()->hasRole('Sales Manager') || Auth::user()->hasRole('Technician'))
                            <li>
                                <a href="javascript:void(0);" class="waves-effect ellipsis">
                                    <i class="remixicon-money-dollar-box-line"></i><span> Sales Management </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-salesofficesmng', 'view'))<li><a href="{{ route('web.salesmng.salesoffice') }}">Sales Offices</a></li>@endif
                                    @if(\Gate::allows('page-approvelicensing', 'view'))<li><a href="{{url('approvelicensing')}}">Approve Licensing</a></li>@endif
                                    <li><a href="{{ route('web.salesmng.salesofficeinitialoffers') }}">Sales Office Initial Offers</a></li>
                                    @if(\Gate::allows('page-assignleadownership', 'view'))<li><a href="{{ route('web.salesmng.assignleadownership') }}">Assign Lead Ownership</a></li>@endif
                                    <li><a href="{{ route('web.salesmng.onboardingusers') }}">On-board Users</a></li>
                                    @if(\Gate::allows('page-personnelmanagement', 'view'))<li><a href="{{ route('web.salesmng.personnelmanagement') }}">Personnel Management</a></li>@endif
                                </ul>
                            </li>
                            @endif
                            <li>
                                <a href="javascript:void(0);" class="waves-effect ellipsis">
                                    <i class="remixicon-price-tag-3-line"></i><span> Ticketing </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="{{ route('web.ticketing.index') }}">Tickets</a></li>
                                    @if(\Gate::allows('page-ClosedTickets', 'view'))<li><a href="{{ route('web.ticketing.closedtickets') }}">Closed Tickets</a></li>@endif
                                    <li><a href="{{ route('web.ticketing.masterscheduler') }}">Master Schedule Calendar</a></li>
                                    <li><a href="{{ route('web.ticketing.mngsubtypes') }}">Manage Sub Types</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect ellipsis">
                                    <i class="remixicon-checkbox-line"></i><span> Tasks & Projects  </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-projectlisting', 'view'))<li><a href="{{ route('web.taskproject.projectlisting') }}">Project Listings</a></li>@endif
                                    @if(\Gate::allows('page-tasklist', 'view'))<li><a href="{{ route('web.taskmanagementlist.tasklist') }}">Task Listings</a></li>@endif
                                    <li>
                                        <a href="javascript:void(0);" class="waves-effect ellipsis">
                                        <i></i><span>Management</span>
                                        <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            @if(\Gate::allows('page-manageprojects', 'view'))<li><a href="{{ route('web.manageprojects.manageproject') }}">Manage Projects</a></li>@endif
                                            @if(\Gate::allows('page-taskstatus', 'view'))<li><a href="{{ route('web.taskstatus.taskstatus') }}">Manage Task Status</a></li>@endif
                                            @if(\Gate::allows('page-tasktag', 'view'))<li><a href="{{ route('web.tasktag.tasktag') }}"> Manage Task Tags</a></li>@endif
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-account-box-line"></i><span> CRM </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-leadslist', 'view'))<li><a href="{{ route('web.crm.leadslist') }}">Lead List</a></li>@endif
                                    @if(\Gate::allows('page-customerlist', 'view'))<li><a href="{{ route('web.crm.customerlist') }}">Customer List</a></li>@endif
                                    @if(\Gate::allows('page-customercommunications', 'view'))<li><a href="{{ route('web.crm.customercommunications') }}">Customer Communications</a></li>@endif
                                    @if(\Gate::allows('page-uploadfundeddeals', 'view'))<li><a href="{{ route('web.crm.uploadfundeddeals') }}">Upload Funded Deals</a></li>@endif
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-bar-chart-box-line"></i><span> Reporting </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-crmreporting', 'view'))<li><a href="{{ route('web.reporting.crmreporting') }}">CRM Reporting</a></li>@endif
                                    <li><a href="{{ route('web.reporting.salesreporting') }}">Sales Reporting</a></li>
                                    <li><a href="{{ route('web.reporting.inventory.index') }}">Inventory Reporting</a></li>
                                    <li><a href="{{ route('web.reporting.user.index') }}">User Reports</a></li>
                                    <li><a href="{{ route('web.reporting.payroll.index') }}">Payroll Reports</a></li>
                                </ul>
                            </li>

                            <li class="menu-title">Admin</li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-equalizer-fill"></i><span> Configurations </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">

                                    <li>
                                        <a href="javascript:void(0);" class="waves-effect ellipsis">
                                        <i></i><span>Customer Interactions</span>
                                        <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            @if(\Gate::allows('page-customervideos', 'view'))<li><a href="{{ route('web.configurations.civ') }}">Customer Videos</a></li>@endif
                                            @if(\Gate::allows('page-surveytemplates', 'view'))<li><a href="{{ route('web.configurations.surveytemplates') }}">Surveys</a></li>@endif
                                            <li><a href="{{ route('web.configurations.surveyresults') }}">Survey Results</a></li>
                                            @if(\Gate::allows('page-notificationrules', 'view'))<li><a href="{{ route('web.configurations.notificationrules') }}">Notification Rules</a></li>@endif
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="waves-effect ellipsis">
                                        <i></i><span>Communications</span>
                                        <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            @if(\Gate::allows('page-emailtemplatetypes', 'view'))<li><a href="{{ url('emailtemplatetypes') }}">Email Types</a></li>@endif
                                            @if(\Gate::allows('page-emailtemplates', 'view'))<li><a href="{{ route('web.configurations.emailtemplates') }}">Email Templates</a></li>@endif
                                            @if(\Gate::allows('page-smstemplatetype', 'view'))<li><a href="{{ route('web.smstemplatetype.index') }}">SMS Types</a></li>@endif
                                            @if(\Gate::allows('page-smstemplates', 'view'))<li><a href="{{ route('web.configurations.smstemplates') }}">SMS Templates</a></li>@endif
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="waves-effect ellipsis">
                                        <i></i><span>Sales</span>
                                        <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            @if(\Gate::allows('page-leadsource', 'view'))<li><a href="{{ route('web.configurations.leadsources') }}">Lead Sources</a></li>@endif
                                            <li><a href="{{ route('web.configurations.propertytype') }}">Account Types</a></li>
                                            @if(\Gate::allows('page-subpropertytype', 'view'))<li><a href="{{ route('web.configurations.subpropertytype') }}">Property Types</a></li>@endif
                                            <li><a href="{{ route('web.configurations.installtype') }}">Install Types</a></li>
                                            <li><a href="{{ route('web.service.index') }}">Service Types</a></li>
                                            @if(\Gate::allows('page-salesterm', 'view'))<li><a href="{{ route('web.configurations.salesterm') }}">Contract Term Management</a></li>@endif
                                            @if(\Gate::allows('page-warrantypackages', 'view'))<li><a href="{{ route('web.configurations.warrantypackages') }}">Warranty Packages</a></li>@endif
                                            @if(\Gate::allows('page-deferredmonthsmng', 'view'))<li><a href="{{ route('web.configurations.deferredmonthsmng') }}">Deferred Months Management</a></li>@endif
                                            @if(\Gate::allows('page-salesprocessconfig', 'view'))<li><a href="{{ route('web.salesmng.salesprocessconfig') }}">Sales Process Configuration</a></li>@endif
                                            @if(\Gate::allows('page-CreditReportConfiguration', 'view'))<li><a href="{{ route('web.salesmng.creditreportconfiguration') }}">Credit Report Configuration</a></li>@endif
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="waves-effect ellipsis">
                                            <i></i><span> Sales Offices </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            @if(\Gate::allows('page-onboarding', 'view'))<li><a href="{{ route('web.configurations.onboarding') }}">On Boarding</a></li>@endif
                                            @if(\Gate::allows('page-statelicensingpackage', 'view'))<li><a href="{{ route('web.configurations.statelicensingpackage') }}">State Licensing Package</a></li>@endif
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="waves-effect ellipsis">
                                        <i></i><span>CRM</span>
                                        <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            @if(\Gate::allows('page-crmtagmng', 'view'))<li><a href="{{ route('web.configurations.crmtagmng') }}">Tag Management</a></li>@endif
                                            @if(\Gate::allows('page-salesstagemng', 'view'))<li><a href="{{ route('web.configurations.salesstagemng') }}">Sales Stage Management</a></li>@endif
                                            @if(\Gate::allows('page-loantype', 'view'))<li><a href="{{ route('web.configurations.loantype') }}">Loan Types</a></li>@endif
                                            @if(\Gate::allows('page-taxes', 'view'))<li><a href="{{ route('web.configurations.taxes') }}">Tax Management</a></li>@endif
                                            @if(\Gate::allows('page-documentcategories', 'view'))<li><a href="{{ route('web.configurations.documentcategories') }}">Documents Categories</a></li>@endif
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-wallet-3-line"></i><span> Payroll Packages </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="javascript:void(0);" class="waves-effect ellipsis">
                                        <i></i><span>Sales Rep Payroll</span>
                                        <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            @if(\Gate::allows('page-mngsalesofficepackage', 'view'))<li><a href="{{route('web.mngsalesofficepackage.index') }}">Sales Office Paysheet</a></li>@endif
                                            {{--
                                                @if(\Gate::allows('page-salesofficemanagerpackage', 'view'))<li><a href="{{route('web.salesofficemanagerpackage.index') }}">Sales Office Manager Package</a></li>@endif
                                             --}}
                                            @if(\Gate::allows('page-overridepackage', 'view'))<li><a href="{{route('web.payrollpackages.overridepackage.index') }}">Sales Rep Paysheet</a></li>@endif
                                            @if(\Gate::allows('page-payrolladminfee', 'view'))<li><a href="{{route('web.payrollpackages.adminfee.index') }}">Admin Fee Package</a></li>@endif
                                            @if(\Gate::allows('page-payrollequipmentpackage', 'view'))<li><a href="{{route('web.payrollpackages.equipmentpackage.index') }}">Equipment Package</a></li>@endif
                                            @if(\Gate::allows('page-passthroughpackage', 'view'))<li><a href="{{route('web.payrollpackages.passthroughpackage.index') }}">Passthrough Package</a></li>@endif
                                            @if(\Gate::allows('page-holdfundandfees', 'view'))<li><a href="{{route('web.payrollpackages.holdfundandfees.index') }}">Hold Fund And Fees</a></li>@endif
                                            @if(\Gate::allows('page-multiplebonus', 'view'))<li><a href="{{route('web.payrollpackages.multiplebonus.index') }}">Multiple Bonus Packages</a></li>@endif
                                            @if(\Gate::allows('page-credittierpackage', 'view'))<li><a href="{{ route('web.credittierpackage.index') }}">Credit Tier Package</a></li>@endif
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="waves-effect ellipsis">
                                        <i></i><span>Technician Payroll</span>
                                        <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            @if(\Gate::allows('page-techpayrollpackage', 'view'))<li><a href="{{route('web.techpayrollpackage.index') }}">Package</a></li>@endif
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('web.payrolldetails.run') }}">Run Payroll</a></li>
                                    <li><a href="{{ route('web.payrollconfiguration.index') }}">Payroll Configuration</a></li>
                                </ul>
                            </li>
							<li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-navigation-line"></i><span> Locations </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-warehouselocal', 'view'))<li><a href="{{ route('web.warehouselocal.index') }}">Warehouses</a></li>@endif
                                    @if(\Gate::allows('page-salesoffices', 'view'))<li><a href="{{ route('web.admin.salesoffice') }}">Sales Offices</a></li>@endif
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-file-list-3-line"></i><span> Documents & Flows </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-ddtype', 'view'))<li><a href="{{ route('web.docflows.ddtype') }}">Digital Document Types</a></li>@endif
                                    @if(\Gate::allows('page-digitaldoc', 'view'))<li><a href="{{ route('web.docflows.digitaldoc') }}">Digital Documents</a></li>@endif
                                    @if(\Gate::allows('page-workflows', 'view'))<li><a href="{{ route('web.workflow.index') }}">Workflows</a></li>@endif
                                    @if(\Gate::allows('page-wfcustomform', 'view'))<li><a href="{{ route('web.workflow.cf_index') }}">Custom Forms</a></li>@endif
                                    @if(\Gate::allows('page-wfcustomform', 'view'))<li><a href="{{ route('web.workflow.cf_results') }}">Form Results</a></li>@endif
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-user-line"></i><span> User Management </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-usermanagement', 'view'))<li><a href="{{ route('web.usermanagement.usermanagement') }}">User Management</a></li>@endif
                                    @if(\Gate::allows('page-roles', 'view'))<li><a href="{{ route('web.usermanagement.roles') }}">User Roles</a></li>@endif
                                    @if(\Gate::allows('page-rolesecurity', 'view'))<li><a href="{{ route('web.usermanagement.rolesecurity') }}">Role Security</a></li>@endif
                                </ul>
                            </li>
							<li>
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="remixicon-download-2-line"></i><span> Integrations </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(\Gate::allows('page-mornitoring', 'view'))<li><a href="{{route('web.integrations.monitoring')}}">Monitoring</a></li>@endif
                                    @if(\Gate::allows('page-communicator', 'view'))<li><a href="{{ route('web.integrations.communicators') }}">Communicators</a></li>@endif
                                    @if(\Gate::allows('page-paymentgateways', 'view'))<li><a href="{{route('web.integrations.paymentgateways')}}">Payment Gateways</a></li>@endif
                                    @if(\Gate::allows('page-creditcheck', 'view'))<li><a href="{{route('web.integrations.creditcheck')}}">Credit Checks</a></li>@endif
                                    @if(\Gate::allows('page-communications', 'view'))<li><a href="{{ route('web.integrations.communications') }}">Communications</a></li>@endif
									@if(\Gate::allows('page-notification', 'view'))<li><a href="{{ route('web.integrations.notification') }}">Notification</a></li>@endif
									@if(\Gate::allows('page-authorizeddealer', 'view'))<li><a href="{{ route('web.integrations.authorizeddealer') }}">Authorized Dealer</a></li>@endif
									@if(\Gate::allows('page-csidmanagement', 'view'))<li><a href="{{ route('web.integrations.csidmanagement') }}">CSID Management</a></li>@endif
									@if(\Gate::allows('page-supplierintegration', 'view'))<li><a href="{{ route('web.integrations.supplier') }}">Supplier</a></li>@endif
                                </ul>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->
