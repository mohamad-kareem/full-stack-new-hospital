const pages = {};

pages.base_url = "http://localhost/hospital/back-end-hospital/";

pages.getAPI = async (api_url) => {
    try{
        return await axios(api_url);
    }catch(error){
        console.log("Error from GET API");
    }
}

pages.postAPI = async (api_url, api_data) => {
    try{
        return await axios.post(
            api_url,
            api_data
        );
    }catch(error){
        console.log("Error from POST API");
    }
}
pages.loadFor = (page) => {
    eval("pages.load_" + page + "();");
}


pages.load_register= () =>{
    const  register =async()=>{
        const registeration_url=pages.base_url +'register.php'
        let name = document.getElementById('name').value;
        let email = document.getElementById('Email').value;
        let date_of_birth = document.getElementById('date_of_birth').value;
        let password = document.getElementById('Password').value;
        let user_type=document.getElementById("type").value
    
        let data = new FormData();
        data.append('name', name);
        data.append('email', email);
        data.append('date_of_birth',date_of_birth);
        data.append('password', password);
        data.append('user_type',user_type)

        response= await pages.postAPI(registeration_url,data)
        
    }
    let signup_btn = document.getElementById('Signup-button');
        signup_btn.addEventListener('click', register);
}


pages.load_login=()=>{
    const  login = async()=>{
        const login_url=pages.base_url +'login.php'

        let email = document.getElementById('Email').value;
        let password = document.getElementById('Password').value;
    
        let data = new FormData();
        data.append('email', email);
        data.append('password', password);

        response= await pages.postAPI(login_url,data)
        console.log(response.data);

        if (response.data.usertype_id == 1) {
            localStorage.setItem('usertype', 'patient');
            window.location.href="../html/patient.html";
            
        } else if (response.data.usertype_id == 2) {
            localStorage.setItem('usertype', 'admin');
            window.location.href="../html/admin.html";
            
        } else if (response.data.usertype_id == 3) {
            localStorage.setItem('usertype', 'employee');
            window.location.href="../html/employee.html";
        }
    }
    let signin_btn = document.getElementById('Signin-button');
    signin_btn.addEventListener('click', login);
}

pages.load_admin = async () => {
    const get_hospitals_url = pages.base_url + 'get-hospitals.php';

    const response = await pages.getAPI(get_hospitals_url);
    const hospitals_names = response.data;
  
    const hospitalsSelect = document.querySelector("#hospitals");
    const hospitalsSelect1 = document.querySelector("#hospitals-emp");
  
    hospitals_names.forEach(hospital => {
      const option = document.createElement("option"); 
      option.value = hospital.name; 
      option.text = hospital.name; 
      hospitalsSelect.add(option); 


      const option1 = document.createElement("option"); 
      option1.value = hospital.name; 
      option1.text = hospital.name; 
      hospitalsSelect1.add(option1);
  
  });
  const assign_patient = async (event) => {
    event.preventDefault(); 
    
    const assign_patient_url = pages.base_url + 'assign-patient.php'
    
    let hospitalname = document.getElementById('hospitals').value;
    let patientname = document.getElementById('patient-name-input').value;
    let isactive = document.getElementById('is-active-checkbox').checked;
    let datejoined = document.getElementById('patient-date-joined').value;
    
    let data = new FormData();
    data.append('hospital_name', hospitalname);
    data.append('patient_name', patientname);
    data.append('is_active', isactive);
    data.append('date_joined', datejoined);
  
    console.log(hospitalname, patientname, isactive, datejoined);
  
    let response = await pages.postAPI(assign_patient_url, data);
    console.log(response.data);
  }
  
   let add_patient_btn = document.getElementById("submit-patient");
   add_patient_btn.addEventListener('click',assign_patient);

   
   
   const assign_employee = async (event) => {
    event.preventDefault(); 
    
    const assign_employee_url = pages.base_url + 'assign-employee.php'
    
    let hospitalname = document.getElementById('hospitals-emp').value;
    let employeename = document.getElementById('employee-name-input').value;
    let isactive = document.getElementById('is-active').checked;
    let datejoined = document.getElementById('employee-date-joined').value;
    
    let data = new FormData();
    data.append('hospital_name', hospitalname);
    data.append('employee_name', employeename);
    data.append('is_active', isactive);
    data.append('date_joined', datejoined);
  
  
    let response = await pages.postAPI(assign_employee_url, data);
    console.log(response.data);
  }

  let add_employee_btn = document.getElementById("submit-employee");
  add_employee_btn.addEventListener('click',assign_employee);

};

  