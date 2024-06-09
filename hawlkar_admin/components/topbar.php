<div class="app-header bg-black-900 flex space-bw">
    <div class="brand space-bw flex center-items">
        <div class="sidebar-toggler mrr-15">
            <i class="bi sidebar-menu-toggler mr-l-5 icon bi-list"></i>
        </div>
        <a href="">
            <img src="./assets/images/Logo-white.png" alt="">
        </a>
    </div>
    <div class="app-header-menu flex center-items">
        <!-- <div class="app-header-menu-item  dd-toggler" data-target-dd="notification-dd">
            <i class="bi icon bi-bell"></i>
            <div class="app-header-dd" id="notification-dd">
                <div class="dd-header">
                    <div class="flex center-items space-bw">
                        <h6 class="bold">Notifications</h6>
                        <span class="act small cursor">Mark all read</span>
                    </div>
                    <p class="text-muted">You have 4 unread notifications</p>
                </div>
                <ul>
                    <li>
                        <div class="flex center-items space-bw">
                            <div class="noti-item center-items flex">
                                <i class="noti-icon danger bi bi-exclamation-circle"></i>
                                <div>
                                    <p>System update required</p>
                                    <span class="small text-muted">10 hours ago</span>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </li>
                    <li>
                        <div class="flex center-items space-bw">
                            <div class="noti-item center-items flex">
                                <i class="noti-icon success bi bi-gem"></i>
                                <div>
                                    <p>All is cool</p>
                                    <span class="small text-muted">5 hours ago</span>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </li>
                    <li>
                        <div class="flex center-items space-bw">
                            <div class="noti-item center-items flex">
                                <i class="noti-icon  bi bi-file-earmark-pdf"></i>
                                <div>
                                    <p>New file uploaded</p>
                                    <span class="small text-muted">4 hours ago</span>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </li>
                    <li>
                        <div class="flex center-items space-bw">
                            <div class="noti-item center-items flex">
                                <i class="noti-icon  bi bi-person-add"></i>
                                <div>
                                    <p>New user added</p>
                                    <span class="small text-muted">4 hours ago</span>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </li>
                </ul>
            </div>
        </div> -->


        <div class="app-header-menu-item toggle-system-color" data-color="dark">
            <i class="bi icon darkmode-toggler bi-moon"></i>
        </div>


        <div class="app-header-menu-item mr-r-15 dd-toggler" data-target-dd="user-profile">
            <img class="cursor" src="./assets/images/Reddington.jpg" alt="">
            <div class="app-header-dd" id="user-profile">
                <div class="dd-header">
                    <div class="flex center-items space-bw">
                        <h6 class="bold"><?=$_SESSION['fullName'];?></h6>
                    </div>
                    <p class="text-muted"><?=$_SESSION['role'];?></p>
                </div>
                <ul>
                    <li class="cursor">
                        <div class="flex pad-l pd-l-5 center-items">
                            <i class="bi bi-person-circle mfs-1-5 gray-500 mr-r-10"></i>
                            <p>Profile</p>
                        </div>
                    </li>
                    <li class="cursor">
                        <div class="flex pd-l-5 center-items">
                            <i class="bi bi-gear mfs-1-5 gray-500 mr-r-10"></i>
                            <p>Settings</p>
                        </div>
                    </li>
                    <li class="cursor">
                        <div class="flex pd-l-5 center-items">
                            <i class="bi bi-box-arrow-left mfs-1-5 gray-500 mr-r-10"></i>
                            <a style="margin-top: -3px; text-decoration: none; color: inherit;" href="./logout">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


        <!-- <div class="app-header-menu-item dd-toggler" data-target-dd="settings">
            <i class="bi icon bi-gear"></i>
            <div class="app-header-dd" id="settings">
                <div class="dd-header"> 
                    <div class="flex center-items space-bw">
                        <h6 class="bold">Settings</h6>
                    </div>
                    <p class="text-muted">admin</p>
                </div>
                <ul>
                    <li class="flex">
                        <div class="flex full-flex wrap">
                            <p class="full-flex mfs-9 bold">Theme color</p>
                            <div class="half-flex mr-t-5 flex space-bw">
                                <label class="flex cursor center-items"> 
                                    <input type="radio" class="mr-r-5" name="theme"> 
                                    Light
                                </label>
                                <label class="flex cursor center-items"> 
                                    <input type="radio" class="mr-r-5" name="theme"> 
                                    Dark
                                </label>
                            </div>
                        </div>
                    </li>
                    <li class="flex">
                        <div class="flex full-flex wrap">
                            <p class="full-flex mfs-9 bg-gray-400 bold">Theme color</p>
                            <div class="half-flex mr-t-5 flex space-bw">
                                <label class="flex cursor center-items"> 
                                    <input type="radio" class="mr-r-5" name="theme"> 
                                    Light
                                </label>
                                <label class="flex cursor center-items"> 
                                    <input type="radio" class="mr-r-5" name="theme"> 
                                    Dark
                                </label>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div> -->
    </div>
</div>