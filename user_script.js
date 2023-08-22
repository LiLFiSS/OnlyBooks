let userbox = document.querySelector('.right-element .user-box');

document.querySelector('#user-btn').onclick = () =>{
    userbox.classList.toggle('active');
}

/*document.querySelector('#close-update').onclick = () =>{
    document.querySelector('.edit-user-profile-form').style.display = 'none';
    window.location.href = 'admin-books.php';
}*/

document.querySelector('#close-update').onclick = () =>{
    document.querySelector('.edit-user-profile-form').style.display = 'none';
    window.location.href = 'user-profile.php';
}
