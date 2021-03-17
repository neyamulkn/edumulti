
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                
                <li> <a class="waves-effect waves-dark" href="{{route('admin.dashboard')}}" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Dashboard</span></a></li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-graduation-cap"></i><span class="hide-menu">Academics </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('subject')}}">Subject</a></li>
                        <li><a href="{{route('class')}}">Class</a></li>
                        <li><a href="{{route('category')}}">Main Category</a></li>
                        <li><a href="{{route('subcategory')}}">Sub Category</a></li>
                        <li><a href="{{route('attribute')}}">Attribute</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Course Manage </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.course.list')}}">Courses</a></li>
                       <!--  <li><a href="{{route('admin.course.lessons')}}">Lessons</a></li> -->
                        
                    </ul>
                </li>
                @php $pending_enroll = App\Models\Order::where('payment_method', '!=', 'pending')->where('order_status', 'pending')->count(); @endphp
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu"> Enrolment <span class="badge badge-pill badge-cyan ml-auto">{{$pending_enroll}}</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.orderList')}}"> Enroll History </a></li>
                        <li><a href="{{route('admin.orderList', 'pending')}}"> Pending Enroll <span class="badge badge-pill badge-cyan ml-auto">{{ $pending_enroll }}</span> </a></li>
                        <li><a href="{{route('orderCancelReason.list')}}">Enroll Cancel Reason </a></li>
                       
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Student </span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('student.list')}}">Student</a></li>
                        <li><a href="{{route('student.walletHistory')}}">Wallet Balance</a></li>
                       
                    </ul>
                </li>

                @php $instructorRequest = 0; @endphp
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">Instructors <span class="badge badge-pill badge-primary text-white ml-auto">{{$instructorRequest}}</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="{{route('vendor.list')}}">Instructor List</a></li>
                       
                        <li> <a href="{{route('vendor.list', 'pending')}}">Instructor Request <span class="badge badge-pill badge-primary text-white ml-auto">{{$instructorRequest}}</span></a></li>
                        @if(Auth::guard('admin')->user()->role == 'admin')
                        <li><a href="{{route('admin.withdraw_request')}}">Withdraw request</a></li>
                        <li><a href="{{route('admin.transactions')}}">Transaction history</a></li>
                        <li><a href="{{route('vendor.commission')}}">Instructor Commission</a></li>
                        @endif
                      <!--   <li><a href="#">instructor Subscriptions</a></li> -->
                       
                    </ul>
                </li>

                <li> <a class="waves-effect waves-dark" href="{{route('adminReviewList')}}" aria-expanded="false"><i class="fa fa-comments"></i><span class="hide-menu">Reviews</span></a></li>
                
                <li> <a class="waves-effect waves-dark" href="{{route('admin.message')}}" aria-expanded="false"><i class="ti-email"></i><span class="hide-menu">Messages <span class="badge badge-pill badge-warning ml-auto">0</span></span></a></li>
                <li> <a class="waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-clipboard"></i><span class="hide-menu">Reports</span></a></li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-align-left"></i><span class="hide-menu">HomePage Setting</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('admin.homepageSection')}}">Homepage</a></li>
                        <li><a href="{{route('menu')}}">Menus</a></li>
                        <li><a href="{{route('slider.create')}}">Sliders</a></li>
                        <li><a href="{{route('service.list')}}">Services</a></li>
                        <li><a href="{{route('banner')}}">All Banner</a></li>
                       <!--  <li><a href="javascript:void(0)">Category Section</a></li>
                        <li><a href="javascript:void(0)">Customer Reviews</a></li>
                        <li><a href="javascript:void(0)">Patners</a></li> -->
                       
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-newspaper"></i><span class="hide-menu">Manage Pages</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('page.create')}}">Add New Page</a></li>
                        <li><a href="{{route('page.list')}}">Page list</a></li>
                    </ul>
                </li>

                <li> <a class="waves-effect waves-dark" href="{{route('paymentGateway')}}" aria-expanded="false"><i class="fa fa-dollar-sign"></i><span class="hide-menu">Payment Gateway</span></a></li>

                
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('generalSetting')}}">General Setting</a></li>
                        <li><a href="{{route('admin.profileUpdate')}}">Profile Setting</a></li>
                        <li><a href="{{route('admin.passwordChange')}}">Change Password</a></li>
                        <li><a href="{{route('logoSetting')}}">Logo Setting</a></li>
                        <li><a href="{{route('socialSetting')}}">Social Link</a></li>
                    </ul>
                </li>

                <li> <a class="waves-effect waves-dark" href="{{route('coupon')}}" aria-expanded="false"><i class="fa fa-people-carry"></i><span class="hide-menu">Manage Coupon</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('adminLogout') }}"  aria-expanded="false"><i class="fa fa-power-off text-success"></i><span class="hide-menu">Log Out</span></a></li>
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>