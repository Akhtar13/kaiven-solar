import {initializeApp} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";
import {
    addDoc,
    collection,
    doc,
    getFirestore,
    onSnapshot,
    orderBy,
    query
} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-firestore.js"

$(function () {

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);
    const docRef = doc(db, "chatChannels", channel_id);
    const messagesCollectionRef = collection(docRef, "messages");
    const userRef = doc(db, "users", created_by);
    let message_array = [];

    const timeConverter = (UNIX_timestamp) => {
        var a = new Date(UNIX_timestamp);
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
        return time;
    }

    const createdByLine = (message) => {
        let text_bg_class = 'bg-light-info'
        if (message.type == 'IMAGE') {
            text_bg_class = ''
            message.message = '<img src="' + message.message + '" style="max-width:150px;" />'
        }
        return '<div class="d-flex justify-content-start mb-10">\n' +
            '               <div class="d-flex flex-column align-items-start">\n' +
            '                    <div class="d-flex align-items-center mb-2">\n' +
            '                       <div class="symbol symbol-35px symbol-circle">\n' +
            '                           <img alt="Pic" src="' + message.image + '" onerror="this.src=default_image"/>\n' +
            '                       </div>\n' +
            '                    <div class="ms-3">\n' +
            '                         <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">' + message.name + '</a>\n' +
            '                         <span class="text-muted fs-7 mb-1">' + message.created_at + '</span>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '                <div class="p-5 rounded ' + text_bg_class + ' text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">' + message.message + '</div>\n' +
            '            </div>\n' +
            '      </div>';
    }
    const sitterLine = (message) => {
        let text_bg_class = 'bg-light-primary'
        if (message.type == 'IMAGE') {
            text_bg_class = ''
            message.message = '<img src="' + message.message + '" style="max-width:150px;" />'
        }
        return '<div class="d-flex justify-content-end mb-10">\n' +
            '               <div class="d-flex flex-column align-items-end">\n' +
            '                    <div class="d-flex align-items-center mb-2">\n' +
            '                       <div class="symbol symbol-35px symbol-circle">\n' +
            '                           <img alt="Pic" src="' + message.image + '" onerror="this.src=default_image"/>\n' +
            '                       </div>\n' +
            '                    <div class="ms-3">\n' +
            '                         <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">' + message.name + '</a>\n' +
            '                         <span class="text-muted fs-7 mb-1">' + message.created_at + '</span>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '                <div class="p-5 rounded ' + text_bg_class + ' text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">' + message.message + '</div>\n' +
            '            </div>\n' +
            '      </div>';
    }
    const triggerScroll = () => {
        $("#message_list").scrollTop($("#message_list")[0].scrollHeight);
    }
    let unsubscribe;

    function startRealtimeListener() {
        const sitter_id = $("#sitter_id").val()
        console.log(sitter_id)
        unsubscribe = onSnapshot(query(messagesCollectionRef, orderBy("time")), (snapshot) => {
            snapshot.docChanges().forEach((change) => {
                if (change.type === "added" && change.doc.data() != undefined) {
                    let html = ''
                    let is_your_message = 0
                    let name = sitter_name
                    let image = sitter_image
                    if (change.doc.data().senderId == created_by) {
                        html = createdByLine({
                            is_your_message: 1,
                            name: created_by_name,
                            image: created_by_image,
                            type: change.doc.data().type,
                            created_at: timeConverter(change.doc.data().time),
                            message: change.doc.data().text,
                        })
                    } else {
                        html = sitterLine({
                            is_your_message: is_your_message,
                            name: name,
                            image: image,
                            type: change.doc.data().type,
                            created_at: timeConverter(change.doc.data().time),
                            message: change.doc.data().text,
                        })
                    }
                    $("#message_list").append(html)
                    triggerScroll()
                    readChat()
                    loaderHide();
                }
            });
        });
    }

    function stopRealtimeListener() {
        if (unsubscribe) {
            unsubscribe();
            unsubscribe = null;
        }
    }

    const sendSMS = (user_id,from_user_id, message, service_user_id, service_id) => {
        axios
            .post(APP_URL + '/send-chat-notification', {
                from_user_id: from_user_id,
                user_id: user_id,
                service_id: service_id,
                service_user_id: service_user_id,
                message: message
            })
            .then(function (response) {
                loaderHide()
            })
            .catch(function (error) {
                console.log(error)
                loaderHide()
            })
    }

    const readChat = () => {
        const service_user_id = $("#service_user_id").val()
        axios
            .post(APP_URL + '/read-chat', {
                service_user_id: service_user_id,
            })
            .then(function (response) {
                loaderHide()
            })
            .catch(function (error) {
                console.log(error)
                loaderHide()
            })
    }

    startRealtimeListener();
    const sendMessage = async () => {
        const message = $('#message_value').val();
        $('#message_value').val('');
        let serviceId = $("#service_id").val()
        let service_user_id = $("#service_user_id").val()
        let from_user_id = $("#created_by_id").val()
        if (message != '') {
            let time_sec = Date.now();
            sendSMS(sitter_id,from_user_id, message, service_user_id, serviceId)
            await addDoc(messagesCollectionRef, {
                text: message,
                mode: '1',
                recipientId: sitter_id,
                senderId: created_by,
                serviceId: serviceId,
                type: 'TEXT',
                time: time_sec,
            });
            let html = createdByLine({
                is_your_message: 1,
                name: created_by_name,
                image: created_by_image,
                created_at: timeConverter(time_sec),
                message: message,
            })
            sendSMS(sitter_id, message)

            triggerScroll()
        }
    }

    $("#send_message").on('click', function () {
        sendMessage();
    })
    $("#message_value").on('keydown', function (event) {
        if (event.which == 13) {
            sendMessage();
        }
    })
})




