<!-- Modal -->
<div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog " role="document" style=" max-width: 800px;">
        <form class="modal-content" onsubmit="return saveEmployee(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeLabel">Add new user</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addEmployeeForm">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label class="label" for="fullName">Full name <span class="form-error">This is required</span></label>
                                <input type="text" placeholder="required" class="form-control" id="fullName">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="label" for="phone">Phone <span class="form-error">This is required</span></label>
                                <input type="text" placeholder="required" class="form-control" id="phone" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="email">Email <span class="form-error">This is required</span></label>
                                <input type="email" placeholder="optional" class="form-control" id="email" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="slcRole">Role <span class="form-error">This is required</span></label>
                                <select style="height: 2rem;" class="form-control" id="slcRole">
                                    <option value="Admin">Admin</option>
                                    <option value="Editor">Editor</option>
                                    <option selected value="Author">Author</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="userActions">Actions <span class=" form-error">This is required</span></label>
                                <select class="form-control full sumoselect" multiple="" id="userActions">
                                    <option value="create">Create</option>
                                    <option value="update">Update</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="username">Username <span class="form-error">This is required</span></label>
                                <input type="text" placeholder="required" class="form-control" id="username" >
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="password">Password <span class="form-error">This is required</span></label>
                                <input type="password" class="form-control" id="password">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="userPrivileges">Privileges <span class=" form-error">This is required</span></label>
                                <select  class="form-control full sumoselect" multiple="" id="userPrivileges">
                                    <option value="dashboard">Dashboard</option>
                                    <option value="articles">Articles</option>
                                    <option value="categories">Categories</option>
                                    <option value="users">Users</option>
                                    <option value="settings">Settings</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn cursor primary" style="width: 100px;">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- EditModal -->
<div class="modal fade" id="editEmployee" tabindex="-1" role="dialog" aria-labelledby="editEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog " role="document" style=" max-width: 800px;">
        <form class="modal-content" onsubmit="return editEmployee(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeLabel">Edit user info</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editEmployeeForm">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="label" for="fullNameEdit">Full name <span class="form-error">This is required</span></label>
                                <input type="hidden" id="user_id">
                                <input type="text" class="form-control" id="fullNameEdit">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="label" for="phoneEdit">Phone <span class="form-error">This is required</span></label>
                                <input type="text" class="form-control" id="phoneEdit" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="label" for="emailEdit">Email <span class="form-error">This is required</span></label>
                                <input type="email" class="form-control" id="emailEdit" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="label" for="slcRoleEdit">Role <span class="form-error">This is required</span></label>
                                <select style="height:2rem" class="form-control" id="slcRoleEdit">
                                    <option value="Admin">Admin</option>
                                    <option value="Editor">Editor</option>
                                    <option value="Author">Author</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="userActions4Edit">Actions <span class=" form-error">This is required</span></label>
                                <select class="form-control full sumoselect" multiple="" id="userActions4Edit">
                                    <option value="create">Create</option>
                                    <option value="update">Update</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="userPrivileges4Edit">Privileges <span class=" form-error">This is required</span></label>
                                <select  class="form-control full sumoselect" multiple="" id="userPrivileges4Edit">
                                    <option value="dashboard">Dashboard</option>
                                    <option value="articles">Articles</option>
                                    <option value="categories">Categories</option>
                                    <option value="users">Users</option>
                                    <option value="settings">Settings</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="label" for="slcStatus4Edit">Status <span class="form-error">This is required</span></label>
                                <select style="height:2rem" class="form-control" id="slcStatus4Edit">
                                    <option value="Active">Active</option>
                                    <option value="Deleted">Delete</option>
                                    <option value="Suspended">Suspend</option>
                                </select>
                            </div>
                        </div>
                    </div>

















                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="twitter">Twitter <span class=" form-error">This is required</span></label>
                                <input class="form-control" name="twitter" id="twitter"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="facebook">Facebook <span class=" form-error">This is required</span></label>
                                <input  class="form-control full" id="facebook"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="web">Web <span class=" form-error">This is required</span></label>
                                <input  class="form-control full" id="web"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="bio">Bio <span class=" form-error">This is required</span></label>
                                <textarea rows="2" class="form-control" name="bio" id="bio"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group flex wrap">
                                <label class="label full-flex" for="linkedin">Linkedin <span class=" form-error">This is required</span></label>
                                <input  class="form-control full" id="linkedin"/>
                            </div>
                        </div>
                    </div>
















                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" style="width: 100px;" class="mbtn cursor primary ">Edit</button>
            </div>
        </form>
    </div>
</div>

