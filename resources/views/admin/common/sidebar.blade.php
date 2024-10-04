<div class="ec-left-sidebar ec-bg-sidebar">
			<div id="sidebar" class="sidebar ec-sidebar-footer">

				<div class="ec-brand">
					<a href="{{url('sysadmin/dashboard')}}" title="PARIHARA">
                         
						 <img class="ec-brand-icon" src="{{asset('admin/assets/img/logo/ec-site-logo.png')}} " style="height: 72px;" alt="" /> 
						
					</a>
				</div>

				<!-- begin sidebar scrollbar -->
				<div class="ec-navigation" data-simplebar>
					<!-- sidebar menu -->
					<ul class="nav sidebar-inner" id="sidebar-menu">
						<!-- Dashboard -->
						<li class="active">
							<a class="sidenav-item-link" href="{{url('sysadmin/dashboard')}}">
								<i class="mdi mdi-view-dashboard-outline"></i>
								<span class="nav-text">Dashboard</span>
							</a>
							<hr>
						</li>



						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/slider-list')}}">
								<i class="mdi mdi-dns-outline"></i>
								<span class="nav-text">Home Manager</span> <b class="caret"></b>
							</a>
							
						</li>
                        
                         <li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
									<i class="mdi mdi-truck-delivery"></i>
								<span class="nav-text">Manage Cab</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/set-price')}}">
											<span class="nav-text">Set Price</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/drivers-list')}}">
											<span class="nav-text">Manage Drivers</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/trip-list')}}">
											<span class="nav-text">Manage Trip</span>
										</a>
									</li>
								
								</ul>
							</div>
						</li>					
                         <li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
									<i class="mdi mdi-truck-delivery"></i>
								<span class="nav-text">Manage Restaurant</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
								    <li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/delivery-charge')}}">
											<span class="nav-text">Delivery Charges</span>
										</a>
									</li>
								    <li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/category-list')}}">
											<span class="nav-text">Manage Category</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/restaurant-list')}}">
											<span class="nav-text">Restaurant List</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/orders')}}">
											<span class="nav-text">Restaurant Orders</span>
										</a>
									</li>
								</ul>
							</div>
						</li>					

					
				    	<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/coupons')}}">
								<i class="mdi mdi-gift"></i>
								<span class="nav-text">Coupons</span> <b class="caret"></b>
							</a>
						</li>

					
						<!-- Users -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/user-list')}}">
								<i class="mdi mdi-account-group"></i>
								<span class="nav-text">Users</span> <b class="caret"></b>
							</a>
						</li>
					
					
					
						<!-- Users -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/query')}}">
								<i class="mdi mdi-headphones"></i>
								<span class="nav-text">Contact Queries</span> <b class="caret"></b>
							</a>
							
							<hr>
						</li>
                        <!-- Category -->
                        
                        <li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-note"></i>
								<span class="nav-text">Content</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/faq')}}">
											<span class="nav-text">FAQ</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/about-us')}}">
											<span class="nav-text">About Us</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/contact-us')}}">
											<span class="nav-text">Contact Us</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/privacy-policy')}}">
											<span class="nav-text">Privacy Policy</span>
										</a>
									</li>

									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/terms-and-conditions')}}">
											<span class="nav-text">Terms And Conditions</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
                        
					</ul>
				</div>
			</div>
		</div>