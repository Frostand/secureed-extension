function toDashboard (){
    if (window.location.pathname.indexOf('/labs/') !== -1) {
        location.href = '../dashboard.php';
    } else {
        location.href = 'dashboard.php';
    }
}

function toLogout (){
    location.href = '../src/logout.php'; //only found in other public files
}

function toIndex (){
    location.href = '../public/index.php'; //only found in test files
}
