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
        console.log(user_type.value);
        response= await pages.postAPI(registeration_url,data)
        console.log(response.data)
        
    }
    let signup_btn = document.getElementById('Signup-button');
        signup_btn.addEventListener('click', register);
}