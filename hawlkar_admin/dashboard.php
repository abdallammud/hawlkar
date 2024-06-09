<div class=" mcon">
	<div class="dashboard  ">
        <div class="flex center-items space-bw">
            <div style="border-radius:10px;" class="welcome mcon bg-black-800 full-flex pd-a-10 mr-b-20 flex wrap">
                <h4 class="bold white-300 full-flex"><span class=""><?=$_SESSION['fullName'];?> </span>, Welcome back</h4>
                <span class="small text-muted">Monitoring dashboard</span>
            </div>
            
        </div>
        <div class="cards flex flex-gap  mr-t-0" >
            <div class="dash-card bg-black-700 rounded py-3">
                <div class="white-50">
                    <div class="full-flex ">
                        <h6 class="bold mfs-1">Documents</h6>
                    </div>
                    <div class="flex center-items space-bw">
                        <div class="">
                            <h5 class="mfs-2 bold">1,324</h5>
                        </div>
                        <div class="visit-change flex center-items">
                            <span class="bi mfs-3 bi-files"></span>
                        </div>
                    </div>
                    <!--//content-->
                </div>
            </div>
            <div class="dash-card bg-red-700  feature-item rounded py-3">
                <div class="white-50">
                    <div class="full-flex ">
                        <h6 class="bold mfs-1">Tagged Documents</h6>
                    </div>
                    <div class="flex center-items space-bw">
                        <div class="">
                            <h5 class="mfs-2 bold">0024</h5>
                        </div>
                        <div class="visit-change flex center-items">
                            <span class="bi mfs-3 bi-info-circle"></span>
                        </div>
                    </div>
                    <!--//content-->
                </div>
            </div>
            <div class="dash-card bg-yellow-400  feature-item rounded py-3">
                <div class="white-50">
                    <div class="full-flex ">
                        <h6 class="bold mfs-1">Shelves</h6>
                    </div>
                    <div class="flex center-items space-bw">
                        <div class="">
                            <h5 class="mfs-2 bold">0523</h5>
                        </div>
                        <div class="visit-change flex center-items">
                            <span class="bi mfs-3 bi-bookshelf"></span>
                        </div>
                    </div>
                    <!--//content-->
                </div>
            </div>
            <div class="dash-card bg-green-700  feature-item rounded py-3">
                <div class="white-50">
                    <div class="full-flex ">
                        <h6 class="bold mfs-1">System users</h6>
                    </div>
                    <div class="flex center-items space-bw">
                        <div class="">
                            <h5 class="mfs-2 bold">0324</h5>
                        </div>
                        <div class="visit-change flex center-items">
                            <span class="bi mfs-3 bi-people"></span>
                        </div>
                    </div>
                    <!--//content-->
                </div>
            </div>
        </div>

        
    </div>
</div>
<script>


    addEventListener("DOMContentLoaded", (event) => {
        draw();
    });
</script>