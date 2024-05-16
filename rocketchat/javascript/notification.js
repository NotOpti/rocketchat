// notification.js
function playNotificationSound() {
    const notificationSound = new Audio('php/sounds/noti.mp3');
    notificationSound.play();
}

function checkAndPlayNotificationSound(newMsgId) {
    const lastNotifiedMsgId = sessionStorage.getItem('lastNotifiedMsgId');
    if (newMsgId && newMsgId !== lastNotifiedMsgId) {
        playNotificationSound();
        sessionStorage.setItem('lastNotifiedMsgId', newMsgId);
    }
}
