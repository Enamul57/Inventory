import Token from './Token';
import AppStorage from './AppStorage';

class User{
    responseAfterLogin(res){
        const token = res.data.token;
        const user = res.data.userName;
        if(Token.isValid(token)){
            AppStorage.store(token,user);
        }
     
    }

    responseAfterRegister(res){
        const token = res.data.token;
        const user = res.data.user;
        if(Token.isValid(token)){
            AppStorage.store(token,user);
        }
    }
    hasToken(){
        const storeToken = localStorage.getItem('token');
        if(storeToken){
            return Token.isValid(storeToken) ? true : false
        } 
        false;
    }
    hasLoggedIn(){
        return this.hasToken();
    }
    name(){
        if(this.hasLoggedIn()){
            return localStorage.getItem('user');
        }

    }
    id(){
        if(this.hasLoggedIn()){
            const payload = Token.isValid(localStorage.getItem('token'));
            return payload.sub;
        }
        return false;
    }


}
export default User = new User();