(function () {
  /* ========= sidebar toggle ======== */
  const sidebarNavWrapper = document.querySelector(".sidebar-nav-wrapper");
  const mainWrapper = document.querySelector(".main-wrapper");
  const menuToggleButton = document.querySelector("#menu-toggle");
  const menuToggleButtonIcon = document.querySelector("#menu-toggle i");
  const overlay = document.querySelector(".overlay");
  const signup = document.querySelector('#sign-up');
  const signin = document.querySelector('#sign-in');
  const signout = document.querySelector('#sign-out');
 
  function serialize (data) {
    let obj = {};
    for (let [key, value] of data) {
      if (obj[key] !== undefined) {
        if (!Array.isArray(obj[key])) {
          obj[key] = [obj[key]];
        }
        obj[key].push(value);
      } else {
        obj[key] = value;
      }
    }
    return obj;
  }

  if(signup) {
    signup.addEventListener('click', (e) => {
      e.preventDefault();
  
      let form = document.querySelector('#form-signup');
  
      // Get all field data from the form
      let data = new FormData(form);
      
      // Convert to an object
      let formObj = serialize(data); // to json from FormData
      
      var xhttp = new XMLHttpRequest();
      var csrf = document.querySelector('meta[name="csrf-token"]').content;
      
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 201) {
          window.location.href = "/dashboard";
        } else if(this.readyState == 4 && this.status == 422){
          window.alert('error')
        }
      };
      
      xhttp.open("POST", "/api/register");
      xhttp.setRequestHeader("Accept", "application/json");
      xhttp.setRequestHeader("X-CSRF-TOKEN", csrf );
      xhttp.setRequestHeader("Content-Type", "application/json");
  
  
      if(document.querySelector("#password").value === document.querySelector("#confirm-password").value) {
        xhttp.send(JSON.stringify(formObj))
      } else {
        window.alert('asdasd')
      }
  
    });
  }

  if(signin) {
    signin.addEventListener('click', (e) => {
      e.preventDefault();
  
      let form = document.querySelector('#form-signin');
  
      // Get all field data from the form
      let data = new FormData(form);
      
      // Convert to an object
      let formObj = serialize(data); // to json from FormData
      
      var xhttp = new XMLHttpRequest();
      var csrf = document.querySelector('meta[name="csrf-token"]').content;
      
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 201) {
          console.log(this)
          window.location.href = "/dashboard";
        } else if(this.readyState == 4 && this.status == 422){
          window.alert('error')
        }
      };
      
      xhttp.open("POST", "/api/login");
      xhttp.setRequestHeader("Accept", "application/json");
      xhttp.setRequestHeader("X-CSRF-TOKEN", csrf );
      xhttp.setRequestHeader("Content-Type", "application/json");
      xhttp.send(JSON.stringify(formObj));
    });
  }

  if(signout) {
    signout.addEventListener('click',  () => {
      var xhttp = new XMLHttpRequest();
      var csrf = document.querySelector('meta[name="csrf-token"]').content;
      var jwtoken = document.querySelector('#sign-out-token').value;
      
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          window.location.href = "/login";
        } else if(this.readyState == 4 && this.status == 422){
          window.alert('error')
        }
      };
      
      xhttp.open("POST", "/api/logout");
      xhttp.setRequestHeader("Accept", "application/json");
      xhttp.setRequestHeader("X-CSRF-TOKEN", csrf );
      xhttp.setRequestHeader("Content-Type", "application/json");
      xhttp.setRequestHeader('Authorization', 'Bearer ' + jwtoken);
      xhttp.send();
    });
  }

})();



