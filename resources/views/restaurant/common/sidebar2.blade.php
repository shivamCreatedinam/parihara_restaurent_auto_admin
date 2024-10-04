<div class="ec-left-sidebar ec-bg-sidebar">
			<div id="sidebar" class="sidebar ec-sidebar-footer">

				<div class="ec-brand">
					<a href="{{url('sysadmin/dashboard')}}" title="ANAND">
                         
						 <img class="ec-brand-icon" src="{{asset('admin/assets/img/logo/ec-site-logo.png')}} " alt="" /> 
						
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

						

						<!-- Users -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/user-list')}}">
								<i class="mdi mdi-account-group"></i>
								<span class="nav-text">Users</span> <b class="caret"></b>
							</a>
							
							<hr>
						</li>
                        <!-- Category -->


						<!-- Users -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/sub-admin-list')}}">
								<i class="mdi mdi-account-group"></i>
								<span class="nav-text">Sub Admin Manager</span> <b class="caret"></b>
							</a>
							
							<hr>
						</li>
                        <!-- Category -->


						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/slider-list')}}">
								<i class="mdi mdi-dns-outline"></i>
								<span class="nav-text">Home Manager</span> <b class="caret"></b>
							</a>
							
						</li>

						

						<!-- Category -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-dns-outline"></i>
								<span class="nav-text">Categories</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/category-list')}}">
											<span class="nav-text">Category</span>
										</a>
									</li>
									
								</ul>
							</div>
						</li>

						<!-- Products -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-palette-advanced"></i>
								<span class="nav-text">Products</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="products" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/attributes')}}">
											<span class="nav-text">Attributes List</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/product-list')}}">
											<span class="nav-text">Product List</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						<!-- Orders -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/inventory-list')}}">
								<i class="mdi mdi-palette-advanced"></i>
								<span class="nav-text">Inventory Manager</span> <b class="caret"></b>
							</a>
						</li>
						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/earning')}}">
								<i class="mdi mdi-currency-inr"></i>
								<span class="nav-text">Earning Manager</span> <b class="caret"></b>
							</a>
						</li>
						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/report')}}">
								<i class="mdi mdi-currency-inr"></i>
								<span class="nav-text">Report Manager</span> <b class="caret"></b>
							</a>
						</li>

						<!-- Orders -->
					    <li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-gift"></i>
								<span class="nav-text">Offers & Coupons</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/offers')}}">
											<span class="nav-text">Offer Manager</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/coupons')}}">
											<span class="nav-text">Coupon Manager</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						<!-- Orders -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-cart"></i>
								<span class="nav-text">Orders</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/orders')}}">
											<span class="nav-text">All Order</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/return-orders')}}">
											<span class="nav-text">Return Order</span>
										</a>
									</li>
								</ul>
							</div>
						</li>


						
						<!-- Orders -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-star-outline"></i>
								<span class="nav-text">Ratings</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/ratings')}}">
											<span class="nav-text">Rating & Review</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

					<!-- Orders -->
					    <li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/location')}}">
								<i class="mdi mdi-map-marker"></i>
								<span class="nav-text">Location</span> <b class="caret"></b>
							</a>
							
						</li>

						<!-- Orders -->
					    <li class="has-sub">
							<a class="sidenav-item-link" href="{{url('sysadmin/delivery-charge')}}">
								<i class="mdi mdi-truck-delivery"></i>
								<span class="nav-text">Delivery Charge</span> <b class="caret"></b>
							</a>
							
						</li>

						
						<!-- Notification -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-note"></i>
								<span class="nav-text">Notification</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/notification')}}">
											<span class="nav-text">Notification Manager</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						

						<!-- Orders -->
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
								<i class="mdi mdi-settings"></i>
								<span class="nav-text">Global Settings</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/slots')}}">
											<span class="nav-text">Delivery Slots</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/estimated-days')}}">
											<span class="nav-text">Estimated Delivery Days</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('sysadmin/general-settings')}}">
											<span class="nav-text">General Settings</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

					</ul>
				</div>
			</div>
		</div>