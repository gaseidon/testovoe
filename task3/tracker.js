async function sendVisitData() {
    try {
        const ipResponse = await fetch('https://ipapi.co/json/');
        const { ip, city } = await ipResponse.json();
        const device = navigator.userAgent;
        
        await fetch('/track.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ip, city, device }),
        });
    } catch (error) {
        console.error('Ошибка отслеживания:', error);
    }
}
sendVisitData();