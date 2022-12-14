<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Tell the browser to be responsive to screen width -->
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">

    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <style>

    .groundqty{
       display: block;
    }

    </style>
    <link href="{{asset('assets/plugins/c3-master/c3.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('css/colors/blue.css')}}" id="theme" rel="stylesheet">

    <link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">

    <link rel="stylesheet" href="{{asset('js/dist/css/qrcode-reader.min.css')}}">

    <link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">

    <link href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet"> --}}
    <link href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery/jscroll.min.js"></script>
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>-->
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    



</head>

<body class="fix-header fix-sidebar card-no-border logo-center">


    @include('sweet::alert')

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">

                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->

                            <h2 class="text-white" style="font-weight: 500; font-size:19px"> Medical World</h2>

                            <input type="hidden" id="unique_role" value="{{session()->get('user')->role}}">
                            <input type="hidden" id="unique_from_id" value="{{session()->get('from')}}">

                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        @php
                            $date = new DateTime('Asia/Yangon');

                            $current_Date = $date->format('Y-m-d');
                        @endphp

                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">@lang('lang.notifications')</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Stock Check<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Updated Item</small>
                                                </div>
                                            </a>

                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Voucher<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Check Voucher</small>
                                                </div>
                                            </a>

                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Reorder<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Check Reorder Item</small>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </u
                                l>
                            </div>
                        </li> --}}




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('image/user.jpg')}}" alt="user" class="profile-pic" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{asset('image/user.jpg')}}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{session()->get('user')->name}}</h4>
                                                <p class="text-muted">{{session()->get('user')->email}}</p>
                                                <a href="#" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('change_password_ui')}}"><i class="mdi mdi-account-key"></i> Change Password </a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('logoutprocess')}}"><i class="mdi mdi-power"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item dropdown">


                            <a href="{{ url()->previous() }}" class="nav-link waves-effect waves-dark pt-2"><i class="fa fa-arrow-left"></i> Back</a>
                        </li>
                    </ul>

                    <div class="dropdown">
                      <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang == App::getLocale())
                                  {{$language}}
                            @endif
                      @endforeach
                      </a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                  <a class="dropdown-item english" href="{{url('localization/'.$lang)}}">{{$language}}</a>
                            @endif
                      @endforeach
                      </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">

            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">

                        @if(session()->get('user')->role == "Owner")
                            <li>
                            <a href="{{route('index')}}">
                                <i class="mdi mdi-home" style="font-size: 18px"></i>
                                <span>@lang('lang.home')</span>
                            </a>
                        </li>
                        @endif


                        @if(session()->get('user')->role == "Owner" || session()->get('user')->role == "Stock" || session()->get('user')->role == "Sales" || session()->get('user')->name == "MON" || session()->get('user')->name == "POE")

                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-store" style="font-size: 18px"></i>
                                <span class="hide-menu">
                                    @lang('lang.inventory') <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">

                                <li><a href="{{route('inven_dashboard')}}">@lang('lang.inventory_dashboard')</a></li>
                                <li><a href="{{route('category_list')}}">@lang('lang.category') @lang('lang.list')</a></li>
                                <li><a href="{{route('subcategory_list')}}">@lang('lang.subcategory') @lang('lang.list')</a></li>
                                <li><a href="{{route('item_list')}}">Sales Product @lang('lang.list')</a></li>
                                <li><a href="{{route('factoryitem_list')}}">Factory Item @lang('lang.list')</a></li>
{{--                                Specification List--}}
                                <li>
                                    <a class="has-arrow " href="#" aria-expanded="false">
                                        <span class="hide-menu">
                                    Specification List</i>
                                </span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li>
                                            <a href="{{ route('specs',1) }}">Design</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('specs',2) }}">Fabric</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('specs',3) }}">Color</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('specs',4) }}">Size</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('specs',5) }}">Gender</a>
                                        </li>
                                    </ul>
                                </li>


                            </ul>
                        </li>
                        @endif

                        @if(session()->get('user')->role == "Owner" || session()->get('user')->role == "Stock" || session()->get('user')->name == "HOK" || session()->get('user')->role == "Sales_Inventory")
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-cart" style="font-size: 18px"></i>
                                <span class="hide-menu">
                                    @lang('lang.stock') <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">

                                <li><a href="{{route('stock_dashboard')}}">@lang('lang.stock_panel')</a></li>
                                <li><a href="{{route('stock_count')}}">@lang('lang.stock_count') and Price</a></li>
                                
                                <li><a href="{{route('stock_reorder_page')}}">@lang('lang.reorder_item')</a></li>
                                <li><a href="{{route('stock_lists')}}">@lang('lang.total_inventory_value')</a></li>
                            </ul>
                        </li>
                        @endif

                        @if(session()->get('user')->role == "Owner" || session()->get('user')->role == "Sales" || session()->get('user')->role == "Sales_Inventory")
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-sale" style="font-size: 18px"></i>
                                <span class="hide-menu">
                                    @lang('lang.sales') <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">

                                <li><a href="{{route('sale_panel')}}">@lang('lang.sales') @lang('lang.panel')</a></li>
                                <li><a href="{{route('sale_page')}}">@lang('lang.sale')</a></li>
                                @if(session()->get('user')->role == "Owner")
                                <li><a href="{{route('sale_history')}}">@lang('lang.sale_history')</a></li>
                                <li><a href="{{ route('saleCount',[$current_Date,$current_Date,'sale']) }}">Item Sales Summary</a></li>
                                <li><a href="{{route('salescustomers_list')}}">@lang('lang.sale_customer_list')</a></li>
                                <li><a href="{{route('discount_record_list')}}">@lang('lang.sale_discount_record')</a></li>
                                @elseif(session()->get('user')->role == "Sales")
                                <li><a href="{{route('salescustomers_list')}}">@lang('lang.sale_customer_list')</a></li>
                                <li><a href="{{route('sale_history')}}">@lang('lang.sale_history')</a></li>
                                @endif
                                <li><a href="{{ route('reset_quantity') }}">Result Quantity</a></li>
                            </ul>
                        </li>
                        @endif


                        @if(session()->get('user')->role == "Owner" || session()->get('user')->role == "Sales" || session()->get('user')->role == "Sales_Inventory")
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-clipboard-text" style="font-size: 18px"></i>
                                <span class="hide-menu">
                                    @lang('lang.order_list') <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('order_panel')}}">@lang('lang.order_panel')</a></li>
                                <li><a href="{{route('neworder_page')}}">Create New Order</a></li>
                                <li><a href="{{route('order_page','1')}}">@lang('lang.incoming_order')</a></li>
                                <li><a href="{{route('order_page','2')}}">@lang('lang.confirm_order')</a></li>
                                @if(session()->get('user')->role == "Owner")
                                <li><a href="{{route('order_page','3')}}">@lang('lang.changes_order')</a></li>
                                @endif
                                <li><a href="{{route('order_page','4')}}">@lang('lang.delivered_order')</a></li>
                                <li><a href="{{route('website_order')}}">Website Instock Order</a></li>
                                <li><a href="{{route('website_preorder')}}">Website Pre-Order</a></li>
                                <!--<li><a href="{{route('order_page','5')}}">@lang('lang.accepted_order')</a></li>-->
                                <li><a href="{{route('order_history')}}">@lang('lang.order_voucher_history')</a></li>
                                <li><a href="{{route('ordercustomers_list')}}">Order Customers List</a></li>
                            </ul>
                        </li>
                        @endif


                        @if(session()->get('user')->role == "Owner" || session()->get('user')->role == "Factory")
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-cart" style="font-size: 18px"></i>
                                <span class="hide-menu">
                                    Factory <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('incomingFactoryOrder')}}">Incoming Factory Orders</a></li>
                                <li><a href="{{route('changeFactoryOrder')}}">Change Factory Orders</a></li>
                                <li><a href="{{route('deliveredFactoryOrder')}}">Delivered Factory Orders</a></li>
                                <li><a href="{{route('newcreate_itemrequest')}}">Creat Factory PO</a></li>
                                <li><a href="{{route('fabric_count')}}">Daily Fabric Count</a></li>
                                @if(session()->get('user')->role == "Factory")
                                    <li><a href="{{route('order_history')}}">@lang('lang.order_voucher_history')</a></li>
                                @endif

                            </ul>
                        </li>
                        @endif


                        @if(session()->get('user')->role == "Owner" )
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-account-multiple-outline" style="font-size: 18px"></i>
                                <span class="hide-menu">
                                    @lang('lang.admin') <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('admin_dashboard')}}">@lang('lang.admin') @lang('lang.panel')</a></li>
                                <li><a href="{{route('employee_list')}}">@lang('lang.employee') @lang('lang.list')</a></li>
                                <!--<li><a href="{{route('customer_list')}}">@lang('lang.customer') @lang('lang.list')</a></li>-->
                                <li><a href="{{route('purchase_list')}}">@lang('lang.purchase') @lang('lang.list')</a></li>
                                <li><a href="{{route('supplier_credit_list')}}">@lang('lang.supplier_credit')</a></li>
                                <!--<li><a href="{{route('itemrequestlists')}}">@lang('lang.itemrequest') @lang('lang.list')</a></li>-->
                                <li><a href="{{route('factorypo_page')}}">Factory PO List</a></li>
                                <li><a href="{{route('itemadjust-lists')}}">@lang('lang.item_adjust') @lang('lang.list')</a></li>
                                <li><a href="{{route('products_flag')}}">Product Flag Control</a></li>
                                <li><a href="{{route('products_qty')}}">Instock / Preorder</a></li>
                                <li><a href="{{route('website_user')}}">Website User</a></li>
                                <li><a href="{{route('email_marketing')}}">Email Marketing</a></li>
                            </ul>
                        </li>
                        @endif

                        @if(session()->get('user')->role == "Owner" || session()->get('user')->role == "Finance" )
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-account-multiple-outline" style="font-size: 18px"></i>
                                <span class="hide-menu">
                                    @lang('lang.finan') <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('financial')}}">Profit & Loss</a></li>
                                <li><a href="{{route('expenses')}}">@lang('lang.expenses') @lang('lang.list')</a></li>
                                <li><a href="{{route('incomes')}}">Income @lang('lang.list')</a></li>
                                <li><a href="{{route('fixasset')}}">@lang('lang.fixasset') </a></li>
                                <li><a href="{{route('show_capital')}}">Capital Panel</a></li>
                                <li><a href="{{ route('bank_list') }}">Bank Account Lists</a></li>
                                <li><a href="{{ route('admin_transaction_lists') }}">Transaction @lang('lang.list')</a>
                                </li>
                                <li><a href="{{route('receivable_payable_lists')}}">Receivable and Payable</a>
                                </li>
                                
                                @if(session()->get('user')->role == "Finance")
                                <li><a href="{{route('purchase_list')}}">@lang('lang.purchase') @lang('lang.list')</a></li>
                                <li><a href="{{route('supplier_credit_list')}}">@lang('lang.supplier_credit')</a></li>
                                <li><a href="{{route('sale_history')}}">@lang('lang.sale_history')</a></li>
                                <li><a href="{{route('salescustomers_list')}}">@lang('lang.sale_customer_list')</a></li>
                                <li><a href="{{route('discount_record_list')}}">@lang('lang.sale_discount_record')</a></li>
                                <li><a href="{{route('order_history')}}">@lang('lang.order_voucher_history')</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        @if(session()->get('user')->role == "Partner")
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-sale" style="font-size: 18px"></i>
                                <span class="hide-menu">
                                    Reports <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('sale_history')}}">@lang('lang.sale_history')</a></li>
                            <li><a href="{{route('order_page','1')}}">@lang('lang.incoming_order')</a></li>
                            </ul>
                        </li>
                        @endif


                        <li>
                            <a href="{{route('logoutprocess')}}"><i class="mdi mdi-power" style="font-size: 18px"></i> <span>@lang('lang.logout')</span></a>
                        </li>
                        @php
                        $shopname= session()->get('from');
                        switch ($shopname) {
                          case '1':
                              $shop_name="Medical World";
                              break;
                          case '2':
                          $shop_name="ရွှေကြာဖြူ(Super 9)";
                          break;
                          case '3':
                              $shop_name="ရွှေကြာဖြူ(35)";
                              break;
                          default:
                          $shop_name="Medical World";
                            break;
                      }
                        @endphp
                         <li>
                          <span class="text-primary" style="margin-left: 20px;font-weight:600">{{session()->get('user')->name}}</span>
                      </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>

        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                {{-- <div class="row page-titles">

                    @yield('place')

                </div> --}}

                @yield('content')

            </div>
            <div id="mobileprint" class="d-none">

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2018 Material Pro Admin by wrappixel.com </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/plugins/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('js/custom.min.js')}}"></script>

    <!--c3 JavaScript -->
    <script src="{{asset('assets/plugins/d3/d3.min.js')}}"></script>

    <script src="{{asset('assets/plugins/c3-master/c3.min.js')}}"></script>

    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>

    <script src="{{asset('assets/plugins/popper/popper.min.js')}}"></script>

    <script src="{{asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('js/validation.js')}}"></script>

    <script src="{{ asset('js/dist/js/qrcode-reader.min.js')}}"></script>

    <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

    <script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    
    <script src="{{asset('assets/js/Chart.bundle.min.js')}}"></script>


    @yield('js')

    <script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>
    <script>

        function clearLocalstorage(right_now_customer) {

        if (right_now_customer != 0) {

            var cartname = "mycart_" + right_now_customer;
            var grand_totalname = "grandTotal_" + right_now_customer;

            var local_customer = localStorage.getItem('local_customer_lists');
            var local_customer_array = JSON.parse(local_customer);
            $.each(local_customer_array, function(i, v) {
                if (v == right_now_customer) {
                    local_customer_array.splice(i, 1);
                }
            })
            localStorage.setItem('local_customer_lists', JSON.stringify(local_customer_array));
            localStorage.removeItem(cartname);
            localStorage.removeItem(grand_totalname);
        }
        localStorage.removeItem('mycart');
        localStorage.removeItem('grandTotal');
        localStorage.removeItem('editvoucher');
        }

        setInterval(() => {
           var rolename= $('#unique_role').val();
           if(rolename=='Counter'){
            var from_id= $('#unique_from_id').val();
           }else if(rolename=='Owner'){
            var from_id= '1';
           }
           var mobileprint = localStorage.getItem('mobileprint');
           if(rolename=="Counter" || rolename=='Owner'){
               console.log(rolename,from_id);

               $.ajax({

                type:'POST',

                url:'/mobile-print',

                data:{
                    "_token":"{{csrf_token()}}",
                    "from_id":from_id,
                },

                success:function(data){

                    if(mobileprint==null){
                        mobileprint = 0;
                    }

                   if(data){

                    if(data.id>mobileprint){
                    var items= ``;
                    var jj=1;
                    $.each(data.counting_unit, function(i,v){
                        console.log(v);
                        if(v.pivot.discount){
                            price_wif_discount = v.pivot.price - parseInt(v.pivot.discount);
                        }else{
                            price_wif_discount = v.pivot.price ;
                        }
                        items+=`
                        <tr style="width:100%; font-size:12px">
                            <td class="text-black">${jj++}</td>
                            <td class="text-black">${v.unit_name} <br> ${v.pivot.quantity} * ${price_wif_discount}</td>
                            <td id="subtotal" style="text-align:right" class="text-black">${price_wif_discount * v.pivot.quantity}</td>
                        </tr>
                        `;
                    });
                    var adddress = ``;
                    if(from_id == 1){
                        adddress += `<address>

                                        <h5 class="text-black" style="text-align:center;color:black;margin:0"> &nbsp;<b class="text-center">Shwe Kyar Phyu (ပင်ရင်း)</b></h5>
                                        <h5 class="text-black" style="text-align:center;color:black;margin:0"> &nbsp; 09420022490</h5>
                                    </address>`;
                    }
                    else if(from_id==2){
                        adddress +=    `<address>
                                        <h5 class="text-black" style="text-align:center;color:black;margin:0"> &nbsp;<b class="text-center">Super 9</b></h5>
                                        <h5 class="text-black" style="text-align:center;color:black;margin:0"> &nbsp; 09883311613</h5>
                                    </address>`;
                    }
                    else{
                        adddress +=`<address>
                                        <h5 class="text-black" style="text-align:center;color:black;margin:0"> &nbsp;<b class="text-center">Shwe Kyar Phyu (35)</b></h5>
                                        <h5 class="text-black" style="text-align:center;color:black;margin:0"> &nbsp; 09897976211</h5>
                                    </address>`;
                    }

                    var url = "{{asset('image/Shwe_Kyar_Phyu.png')}}";
                       var html = `

            <div class="row justify-content-center">
                <div class="col-md-5 printableArea" style="width:100%;" id="printableArea">
                    <div class="card card-body">
                        <div class="row" style="margin:10px">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <img src= '${url}' alt="" style="width:60px;height:60px;display: block;margin-left: auto;margin-right: auto;">
                                    ${adddress}

                                </div>
                                <div class="pull-right text-left" style = "color:black;">
                                <p style="width:100%">
                                <span class="text-black" style="float:right;">${data.voucher_date}</span>
                                အရောင်းပြေစာ : ${data.voucher_code}
                                </p>
                                </div>
                                <div class="pull-right text-left" style = "color:black;">
                                <p style="width:100%">
                                <span class="text-black" style="float:right;">${data.created_at}</span>
                                အရောင်း၀န်ထမ်း : ${data.user.name ?? ""}
                                </p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive text-black" style="clear: both;  margin: 0 auto;">
                                    <table class="table table-hover" style="width:100%; font-size:12px">
                                        <thead style="font-size:12px;width:100%">
                                            <tr class="text-black">
                                                <th style="text-align:left">No.</th>
                                                <th style="text-align:left">Name</th>
                                                <th style="text-align:right;padding-left:10px">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody style="width:100%; font-size:12px">

                                            ${items}

                                        </tbody>
                                        <tfoot style="width:100%; font-size:12px">
                                            <tr>
                                            <td colspan="7" style="padding:0;margin:0">
                                            </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="text-right text-black" > <br>ကျသင့်ငွေပေါင်း(MMK)</td>
                                                <td id="total_charges" style="text-align:right" class="font-weight-bold text-black" > <br>${data.total_price}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="text-right text-black" >ပေးငွေ(MMK)</td>
                                                <td id="pay"  style="text-align:right" class="font-weight-bold text-black" >${data.pay}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="text-right text-black" >ပြန်အမ်းငွေ(MMK)</td>
                                                <td id="changes"  style="text-align:right" class="font-weight-bold text-black" > ${data.change}</td>
                                            </tr>
                                            <td colspan="7" style="padding:0;margin:0">
                                            </td>
                                        </tfoot>
                                    </table>
                                    <h6 class="text-center font-weight-bold text-black" style="width:100%; font-size:12px;text-align:center">**၀ယ်ပြီးပစ္စည်းပြန်မလဲပါ***</h6>
                                    <h6 class="text-center font-weight-bold text-black" style="width:100%; font-size:12px;text-align:center">**ကျေးဇူးတင်ပါသည်***</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                       `;

            $('#mobileprint').html(html);
            localStorage.setItem('mobileprint',JSON.stringify(data.id));

            var printContent = $('#mobileprint')[0];
            var WinPrint = window.open('', '', 'width=900,height=650');
            WinPrint.document.write('<html><head><title>Print Voucher</title>');
            WinPrint.document.write('<link rel="stylesheet" type="text/css" href="css/style.css">');
            WinPrint.document.write('<link rel="stylesheet" type="text/css" media="print" href="css/print.css">');
            WinPrint.document.write('</head><body >');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.write('</body></html>');

            // WinPrint.document.write(html);
            WinPrint.focus();
            WinPrint.print();
            WinPrint.document.close();
            WinPrint.close();

            // var printContent = document.getElementById('printableArea');
            // var WinPrint = window.open('', '', 'width=900,height=650');
            // console.log(WinPrint);
            // WinPrint.document.write(html);
            // WinPrint.focus();
            // WinPrint.print();
            // WinPrint.document.close();
            // WinPrint.close();

            // var mode = 'iframe'; //popup
            // var close = mode == "iframe";
            // var options = {
            //     mode: mode,
            //     popClose: close
            // };
            // $("#mobileprint .row div.printableArea").printArea(options)
                   }
                   }
                },


                });
           }
        }, 5000);

    </script>

</body>

</html>
