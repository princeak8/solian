            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img src="{{asset('assets/img/logo.png')}}"  srcset="">
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">      
                        <li class='sidebar-title'>{{__("Main Menu")}}</li>                   
                    
                        <li class="sidebar-item active ">
                            <a href="{{url('/')}}" class='sidebar-link'>
                                <i data-feather="home" width="20"></i> 
                                <span>{{__("Dashboard")}}</span>
                            </a>
                            
                        </li>

                        <li class="sidebar-item">
                            <a href="{{url('candidates/')}}" class='sidebar-link'>
                                <i data-feather="search" width="20"></i> 
                                <span>{{__("Candidates")}}</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-item">
                            <a href="{{url('adverts/')}}" class='sidebar-link'>
                                <i data-feather="briefcase" width="20"></i> 
                                <span>{{__("Projects")}}</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{url('category')}}" class='sidebar-link'>
                                <i data-feather="box" width="20"></i> 
                                <span>{{__("Base Categories")}}</span>
                            </a>
                            
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="tool" width="20"></i> 
                                <span>{{__("Settings")}}</span>
                            </a>
                            
                            <ul class="submenu ">
                                
                                <li>
                                    <a href="{{url('settings/platforms')}}">{{__('Platforms')}}</a>
                                </li>                                
                                <li>
                                    <a href="{{url('settings/subCategories')}}">{{__('Sub Categories')}}</a>
                                </li>
                                <li>
                                    <a href="{{url('settings/partners')}}">{{__('Partners')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="settings" width="20"></i> 
                                <span>{{__("Admin")}}</span>
                            </a>
                            
                            <ul class="submenu ">
                                <li>
                                    <a href="{{url('admin/letters')}}">{{__('Letters')}}</a>
                                </li>
                                <li>
                                    <a href="{{url('admin/users')}}">{{__('Users')}}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>