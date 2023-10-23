class AppStorage{

    storeToken(token){
        localStorage.setItem('token',token);
    }
   
    storeUser(user){
        localStorage.setItem('user',user);
    }
    
    storeUserId(user_id){
        localStorage.setItem('user_id',user_id);
    }
    
    storeUserType(user_type){
        localStorage.setItem('user_type',user_type);
    }
   
    store(token,user,user_id,user_type){
        this.storeToken(token)
        this.storeUser(user)
        this.storeUserId(user_id)
        this.storeUserType(user_type)
    }
   
     clear(){
         localStorage.removeItem('token')
         localStorage.removeItem('user')
         localStorage.removeItem('user_id')
         localStorage.removeItem('user_type')
     }
   
     getToken(){
         localStorage.getItem(token);
     }
   
     getUser(){
        localStorage.getItem(user);
    }

    getUserId(){
        localStorage.getItem(user_id);
     }

     getUserType(){
        localStorage.getItem(user_type);
     }
   
   
   
   }
   
   export default AppStorage = new AppStorage();