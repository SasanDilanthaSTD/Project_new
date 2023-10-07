'use strict';


//buttons
let callBtn    = $('#callBtn');
let callBox    = $('#callBox');
let answerBtn  = $('#answerBtn');
let declineBtn = $('#declineBtn');
let chatBody = $('#chatBody');
let video = $('#video');
let hangupBtn = $('#hangupBtn');

// document.addEventListener("DOMContentLoaded", function() {
//
//     var callBtn = document.getElementById("callBtn");
//
//     callBtn.addEventListener("click", function() {
//         getCam();
//     });
// });


let pc;
let  sendTo = callBtn.data('user');
let localStream;

//video elements
const localVideo = document.querySelector("#localVideo");
const remoteVideo = document.querySelector("#remoteVideo");

//media info
const mediaConst = {
    video:true
};

//what to receive from other client
const options ={
    offerToReceiveVideo:1,
}

function getConn(){
    if (!pc) {
        pc = new RTCPeerConnection();
    }
}

//ask for media input
async function getCam() {
    let mediaStream;
    try {
        if (!pc) {
            await getConn();
        }

        const mediaConst = { video: true, audio: true }; // Example constraint
        mediaStream = await navigator.mediaDevices.getUserMedia(mediaConst);

        localVideo.srcObject = mediaStream;
        localStream = mediaStream;

        localStream.getTracks().forEach(track => pc.addTrack(track, localStream));
    } catch (error) {
        console.log(error);
    }
}


async function createOffer(sendTo){
    await sendIceCandidate(sendTo);  //provide info about ip address and path
    await pc.createOffer(options);  //generate session description protocol
    await pc.setLocalDescription(pc.localDescription);
    send('client-offer', pc.localDescription, sendTo);
}

async function createAnswer(sendTo, data){
    if (!pc) {
        await getConn();
    }
    if (!localStream) {
        await getCam();
    }

    await sendIceCandidate(sendTo);
    await pc.setRemoteDescription(data);
    await pc.createAnswer();
    await pc.setLocalDescription(pc.localDescription);
    send('client-answer', pc.localDescription, sendTo);
}

function sendIceCandidate(sendTo){
    pc.onicecandidate = e =>{
        if (e.candidate !== null) {
            send('client-candidate', e.candidate, sendTo);
        }
    }

    pc.ontrack = e =>{
        video.removeClass('hidden');
        chatBody.addClass('hidden');
        remoteVideo.srcObject = e.streams[0];
    }
}

callBtn.on("click", () => {
    getCam();
    send('is-client-ready', null, sendTo);
});

conn.onopen = e =>{
    console.log('Connect to WebSocket');
}

conn.onmessage = async e => {
    let message = JSON.parse(e.data);
    let by = message.by;
    let data = message.data;
    let type = message.type;
    let profileImage = message.profileImage;
    let username = message.username;
    $('#username').text(username);
    $('#profileImage').attr('src', profileImage);
    // console.log(username);
    // console.log(send);
    // console.log(message);

    switch (type) {
        case 'client-candidate':
            if (pc.localDescription) {
                await pc.addIceCandidate(new RTCIceCandidate(data));

                hangupBtn.on('click', () =>{
                    send('client-hangup', null, sendTo);
                    video.addClass('hidden');
                    chatBody.removeClass('hidden');
                    location.reload(true);
                });
            }
        break;
        case 'is-client-ready':
            if (!pc) {
                await getConn();
            }
            if (pc.iceConnectionState === "connected") {
                send('client-already-oncall');
            }else {
                //display popup
                displayCall();

                answerBtn.on('click', () => {
                    callBox.addClass('hidden');
                    send('client-is-ready', null, sendTo);
                });

                declineBtn.on('click', () => {
                    send('client-rejected', null, sendTo);
                    location.reload(true);
                });
            }
        break;
        case 'client-answer':
            if (pc.localDescription) {
                await pc.setRemoteDescription(data);
            }
        break;
        case 'client-offer':
            createAnswer(sendTo, data);
        break;
        case 'client-is-ready':
            createOffer(sendTo);
        break;
        case 'client-already-oncall':
            //display popup
            setTimeout('window.location.reload(true)', 2000);
        break;
        case 'client-rejected':
            alert('client rejected the call');
        break;
        case 'client-hangup':
            location.reload(true);
            alert('client hangup the call');
        break;
    }
}

function send(type, data, sendTo){
    conn.send(JSON.stringify({
        sendTo:sendTo,
        type:type,
        data:data
    }));
}

function displayCall(){
    callBox.removeClass('hidden');
}