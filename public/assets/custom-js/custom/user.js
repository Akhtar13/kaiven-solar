import {initializeApp} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";
import {doc, getFirestore, setDoc} from "https://www.gstatic.com/firebasejs/9.22.0/firebase-firestore.js"

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);


let $form = $('#userForm')
$form.on('submit', function (e) {
    e.preventDefault()
    loaderView()
    let formData = new FormData($form[0])
    axios
        .post(APP_URL + form_url, formData)
        .then(function (response) {
            if ($('#form-method').val() === 'add') {
                $form[0].reset()
            }
            const userRef = doc(db, "users", String(response.data.user.id));
            setDoc(userRef, {
                firstName: response.data.user.firstname,
                lastName: response.data.user.lastname,
                id: String(response.data.user.id),
                profile: "",
                profilePicture: "",
                boardingPrice: 0,
                dayCarePrice: 0,
                sittingPrice: 0,
                walkingPrice: 0,
                login: true,
                os: 'WEB',
            });
            setTimeout(function () {
                window.location.href = APP_URL + redirect_url
                loaderHide()
            }, 1000)
            loaderHide()
            notificationToast(response.data.message, 'success')
        })
        .catch(function (error) {
            console.log(error)
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })
})