function toDashboard (){
    if (window.location.pathname.indexOf('/labs/') !== -1) {
        location.href = '../dashboard.php';
    } else {
        location.href = 'dashboard.php';
    }
}

function toLogout (){
    if (window.location.pathname.indexOf('/labs/') !== -1) {
        location.href = '../../src/logout.php';
    } else {
        location.href = '../src/logout.php';
    }
}

function toIndex (){
    location.href = '../public/index.php'; //only found in test files
}
