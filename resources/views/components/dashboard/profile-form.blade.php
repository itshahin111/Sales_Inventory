<!-- The HTML structure -->
<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr/>
                    <!-- Form to display and update user information -->
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <!-- Input fields for email, first name, last name, mobile, and password -->
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <!-- Button to trigger the onUpdate function -->
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  bg-gradient-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript code -->
<script>
    // Function to fetch user profile information
    getProfile();
    async function getProfile(){
        showLoader(); // Display loader while fetching data
        let res=await axios.get("/user-profile"); // Fetch user profile asynchronously
        hideLoader(); // Hide loader after data is fetched
        if(res.status===200 && res.data['status']==='success'){
            let data=res.data['data'];
            // Update input fields with fetched user data
            document.getElementById('firstName').value=data['firstName'];
            document.getElementById('lastName').value=data['lastName'];
            document.getElementById('mobile').value=data['mobile'];
            document.getElementById('password').value=data['password'];
        }
        else{
            errorToast(res.data['message']); // Display error message if request fails
        }
    }

    // Function to handle user update
    async function onUpdate() {
        // Get input values
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let mobile = document.getElementById('mobile').value;
        let password = document.getElementById('password').value;

        // Validate input fields
        if(firstName.length===0){
            errorToast('First Name is required');
        }
        else if(lastName.length===0){
            errorToast('Last Name is required');
        }
        else if(mobile.length===0){
            errorToast('Mobile is required');
        }
        else if(password.length===0){
            errorToast('Password is required');
        }
        else{
            showLoader(); // Display loader while updating user data
            let res=await axios.post("/user-update",{ // Send updated data to server asynchronously
                firstName:firstName,
                lastName:lastName,
                mobile:mobile,
                password:password
            });
            hideLoader(); // Hide loader after update is done
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']); // Display success message
                await getProfile(); // Refresh user profile data after update
            }
            else{
                errorToast(res.data['message']); // Display error message if update fails
            }
        }
    }
</script>
