import {initializeApp} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";
import {
    collection,
    doc,
    getDocs,
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
    const getMessages = async () => {
        $("#message_list").html('')
        const querySnapshot = await getDocs(query(messagesCollectionRef, orderBy("time")));
        // const unsubscribe = onSnapshot(query(messagesCollectionRef, orderBy("time")), (querySnapshot) => {
        querySnapshot.forEach((doc) => {
            let is_your_message = 0
            let name = sitter_name
            let image = sitter_image
            if (doc.data().senderId == created_by) {
                is_your_message = 1
                name = created_by_name;
                image = created_by_image;
            }
            message_array.push({
                is_your_message: is_your_message,
                name: name,
                image: image,
                created_at: timeConverter(doc.data().time),
                message: doc.data().text,
            })
        });
        // });
        // unsubscribe()
        let html = ''
        $(message_array).each(function (index, value) {
            console.log(value)
            if (value.is_your_message == 1) {
                html = createdByLine(value);
            } else {
                html = sitterLine(value);
            }
            $("#message_list").append(html)
            loaderHide();
        })
        triggerScroll()
    }

    const getServiceChatKeyword = () => {
        return new Promise((resolve, reject) => {
            const service_id = $("#service_id").val();
            axios
                .get(APP_URL + '/get-service-chat-keyword/' + service_id)
                .then(function (response) {
                    const service_chat_keyword = response.data.data;
                    resolve(service_chat_keyword);
                })
                .catch(function (error) {
                    console.log(error);
                    reject(error);
                });
        });
    }

    let unsubscribe;

    async function startRealtimeListener() {
        const service_chat_keyword = await getServiceChatKeyword();
        unsubscribe = onSnapshot(query(messagesCollectionRef, orderBy("time")), (snapshot) => {
            snapshot.docChanges().forEach((change) => {
                console.log(change.doc.data());
                if (change.type === "added" && change.doc.data() != undefined) {
                    let html = ''
                    let is_your_message = 0
                    let name = sitter_name
                    let image = sitter_image
                    let text_message = change.doc.data().text;
                    $(service_chat_keyword).each(function (key, value) {
                        if (text_message.includes(value.keyword) && value.user_id == change.doc.data().senderId) {
                            text_message = text_message.replace(value.keyword, '<span style="color:red">' + value.keyword + '</span>');
                        }
                    })
                    if (change.doc.data().senderId == created_by) {
                        html = createdByLine({
                            is_your_message: 1,
                            name: created_by_name,
                            image: created_by_image,
                            type: change.doc.data().type,
                            created_at: timeConverter(change.doc.data().time),
                            message: text_message,
                        })
                    } else {
                        html = sitterLine({
                            is_your_message: is_your_message,
                            name: name,
                            image: image,
                            type: change.doc.data().type,
                            created_at: timeConverter(change.doc.data().time),
                            message: text_message,
                        })
                    }
                    $("#message_list").append(html)
                    triggerScroll()
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

    startRealtimeListener();

})




