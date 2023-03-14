require('./bootstrap');

const channel = Echo.channel('public.overallnotice.1')
channel.subscribed(() => {
            console.log('suscribedd!');
        }).listen('.overallnotice', (event) => {
             $('#staticBackdrop').modal('show');
            document.getElementById('notice2').innerHTML=event["detailedmessage"];
            console.log(event);
        })


const loginchannel = Echo.channel('public.login.1')
loginchannel.subscribed(() => {
    console.log('suscribed to login!');
}).listen('.login', (event) => {
    localStorage.setItem('tokens',event['token']);
    localStorage.setItem('ids',event["id"]);
    localStorage.setItem('notificationss',event["notificationss"]);
})


const specificchannel = Echo.channel('public.specificnotf.1')
specificchannel.subscribed(() => {
    console.log('specificnotf!');
}).listen('.specificnotf', (event) => {
    $('#staticBackdrop').modal('show');
    document.getElementById('notice2').innerHTML=event["message"];
    console.log(event);
})


const specificclasschannel = Echo.channel('public.specificclass.1')
specificclasschannel.subscribed(() => {
    console.log('specificclass!');
}).listen('.specificclass', (event) => {
    $('#staticBackdrop').modal('show');
    document.getElementById('notice2').innerHTML=event["message"];
    console.log(event);
})

const billprintedchannel = Echo.channel('public.billprinted.1')
billprintedchannel.subscribed(() => {
    console.log('billprintedchannel!');
}).listen('.billprinted', (event) => {
    $('#staticBackdrop').modal('show');
    document.getElementById('notice2').innerHTML=event["message"];
    console.log(event);
})

const resultpublishedchannel = Echo.channel('public.resultpublished.1')
resultpublishedchannel.subscribed(() => {
    console.log('resultpublishedchannel!');
}).listen('.resultpublished', (event) => {
    $('#staticBackdrop').modal('show');
    document.getElementById('notice2').innerHTML=event["message"];
    console.log(event);
})
