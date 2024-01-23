<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href=".\assets\css\fontawesome-all.min.css">
  <link rel="stylesheet" href=".\assets\css\customStyle.css">
  <link
    href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css"
    rel="stylesheet"
  />
  <meta
    name="viewport"
    content="width=device-width,initial-scale=1,maximum-scale=1"
  />
<script>
.toast {
      position: fixed;
      bottom: 10px;
      right: 10px;
      width: 300px;
      padding: 10px;
      text-align: center;
      border-radius: 5px;
      color: white;
      font-weight: bold;
    }

    .toast.success {
      background-color: #00ff00; /* Green background for success */
    }

    .toast.error {
      background-color: #ff0000; /* Red background for error */
    }

    .toast i {
      margin-right: 8px;
    }

    .toast.success i {
      color: #00ff00; /* Green color for success icon */
    }

    .toast.error i {
      color: #ff0000; /* Red color for error icon */
    }
    </script>
</head>

<body class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">

  
  <div
    class="max-w-screen-xl m-0 sm:m-20 bg-white shadow sm:rounded-lg flex justify-center flex-1"
  >
    <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
      <div> 
        
      </div>
      <div class="mt-12 flex flex-col items-center">
        <!-- Other buttons are omitted for brevity -->
        <div class="mx-auto max-w-xs">
          <input
          class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
          type="username"
          placeholder="Username" name="username" id="username"
        />
        <input
        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
        type="email"
        placeholder="email" name="email"email="email"
      />
          <!-- <input
            class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
            type="email"
            placeholder="Email" name="email" id="email"
          /> -->
          <input
            class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
            type="password"
            placeholder="Password" name="password" id="password"
          />

          
            <input class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5" type="text" placeholder="Mobile Number" name="mobileNumber" id="mobileNumber" />
            <select class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5" name="gender" id="gender">
              <option value="" disabled selected>Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          
          <button id="signupButton"
            class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
          >
         
            <svg
              class="w-6 h-6 -ml-2"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
              <circle cx="8.5" cy="7" r="4" />
              <path d="M20 8v6M23 11h-6" />
            </svg>
            <span class="ml-3">
              Submit
            </span>
          </button>

          <!-- Additional Login Options -->



          <p class="mt-6 text-xs text-gray-600 text-center">
            I agree to abide by templatana's
            <a href="#" class="border-b border-gray-500 border-dotted">
              Terms of Service
            </a>
            and its
            <a href="#" class="border-b border-gray-500 border-dotted">
              Privacy Policy
            </a>
          </p>
        </div>
      </div>
    </div>
    <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
      <div
        class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
        style="background-image: url('./assets/images/co-working-bg.jpg');"
      ></div>
    </div>
  </div>
  <div class="toast" id="toast" data-bs-autohide="true">
    <div class="loader" id="loader"></div>
    <!-- <div class="toast-body">
        <p id="error_message"></p>
    </div>   -->
</div> 
<!-- 
<div id="toast" class="hide"></div>
<div id="toast" class="hidden">
  <div id="toastText"></div>
</div> -->

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var signupButton = document.getElementById('signupButton');
    var toast = document.getElementById('toast');
    var loader = document.getElementById('loader');

    signupButton.addEventListener('click', function() {
       var username = document.querySelector('input[name="username"]').value;
        var email = document.querySelector('input[name="email"]').value;
        var password = document.querySelector('input[name="password"]').value;
        var mobileNumber = document.querySelector('input[name="mobileNumber"]').value;
        var gender = document.querySelector('select[name="gender"]').value;
      sessionStorage.setItem('userEmail', email);
      var userData = {
          "username": username,
          "email": email,
          "password": password,
          "mobileNumber": mobileNumber,
          "gender": gender
        };

      loader.style.display = 'block'; // Show loader before sending request

      var xhr = new XMLHttpRequest();
      xhr.open('POST', '/salman/API/register.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          loader.style.display = 'none'; // Hide loader after receiving response

          var response = JSON.parse(xhr.responseText);

          if (response.status === true) {
            showToast( response.message, 'success');
          } else {
            showToast(response.error, 'error');
          }
        }
      };

      xhr.send(JSON.stringify(userData));
    });

    function showToast(message, type) {
      var iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-times-circle';
      var toastMessage = `<i class="${iconClass}"></i> ${message}`;

      toast.innerHTML = toastMessage;
      toast.classList.add(type);
      toast.classList.remove('hidden');
      
      if (type === 'success') {
        setTimeout(function() {
        
          window.location.href = 'dashboard.html'; // Redirect upon success
        }, 3000);
      } else {
        setTimeout(function() {
          toast.classList.add('hidden');
          toast.classList.remove('success', 'error');
        }, 3000);
      }
    }
  });
</script>
<!-- <script>
function showToast() {
  var toast = document.getElementById('toast');
  toast.innerHTML = 'This is a toast message!';
  toast.classList.add('show');
  setTimeout(function(){
    toast.classList.remove('show');
  }, 3000); // 3000 milliseconds = 3 seconds
}
</script> -->





</body>

</html>
