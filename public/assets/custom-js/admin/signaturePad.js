/**
 * Copyright (C) 2023 Wacom.
 * Use of this source code is governed by the MIT License that can be found in the LICENSE file.
 */

var mSigObj;
var mHash;

Module.onAbort = _ => {
    alert("Web browser not supported");
    document.getElementById("initializeBanground").style.display = "none";
}

Module.onRuntimeInitialized = _ => {
    document.getElementById("version_txt").innerHTML = Module.VERSION;
    mSigObj = new Module.SigObj();
    mHash = new Module.Hash(Module.HashType.SHA512);

    // Here we need to set the licence. The easiest way is directly using
    // const promise = mSigObj.setLicence(key, secret);
    // however here the problem it is that we expose the key and secret publically.
    // if we want to hide the licence we can get the licence from an external server.
    // there is a php demo file in /common/licence_proxy.php
    //const promise = mSigObj.setLicenceProxy("url from where to get the licence");
    const promise = mSigObj.setLicence("3ebf2f24-014c-45e7-bd58-77d5ea38e2c9", "WaJSr1eVbE13qbCVJy07Aw9m5RGqmEtk79bQqHdzzWtr8CPPbCOCEDKNusiDZ2ZcAIV2/NxHXXNDBuSWKJQE3g==");
    console.log(promise);
    promise.then(value => {
        if (value) {
            if (navigator.hid) {
                document.getElementById("capture_stu_device").disabled = false;
            }

            document.getElementById("canvas_capture_btn").disabled = false;
            document.getElementById("initializeBanground").style.display = "none";
            document.getElementById("myfile").disabled = false;
        }
    });
    promise.catch(error => {
        alert(error);
        document.getElementById("initializeBanground").style.display = "none";
    });
}

async function loadFromFile() {
    const file = document.getElementById("myfile").files[0];
    if (file) {
        // check the type
        if ("text/plain" == file.type) {
            // read the file as string
            const reader = new FileReader();
            reader.onload = async function () {
                const data = reader.result;
                try {
                    if (await mSigObj.setTextData(data)) {
                        renderSignature();
                    } else {
                        alert("Incorrect signature data found");
                    }
                } catch (e) {
                    alert("Error loading signature as text " + e);
                }
            }
            reader.readAsText(file);
        } else if ((file.type == "image/png") ||
            (file.type == "image/jpeg")) {
            const reader = new FileReader();
            reader.onload = async function () {
                const data = reader.result;
                var img = new Image();
                img.addEventListener('load', async function () {
                    //the image has been loaded
                    const canvas = document.createElement("canvas");
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, img.width, img.height);
                    const imageData = ctx.getImageData(0, 0, img.width, img.height);
                    try {
                        await mSigObj.readEncodedBitmapBinary(imageData.data, imageData.width, imageData.height);
                        renderSignature();
                    } catch (e) {
                        alert("Error loading image " + e);
                    }
                }, false);
                img.src = data;
            }
            reader.readAsDataURL(file);
        } else {
            // we assume is binary data
            const reader = new FileReader();
            reader.onload = async function () {
                const data = reader.result;
                try {
                    if (await mSigObj.setSigData(new Uint8Array(data))) {
                        renderSignature();
                    } else {
                        alert("Incorrect signature data found");
                    }
                } catch (e) {
                    alert("Error loading signature as binary " + e);
                }
            }
            reader.readAsArrayBuffer(file);
        }
    }
}

async function renderSignature() {
    //pixels = dpi*mm/25.4mm
    let width = Math.trunc((96 * mSigObj.getWidth(false) * 0.01) / 25.4);
    let height = Math.trunc((96 * mSigObj.getHeight(false) * 0.01) / 25.4);

    let scaleWidth = 300 / width;
    let scaleHeight = 200 / height;
    let scale = Math.min(scaleWidth, scaleHeight);

    let renderWidth = Math.trunc(width * scale);
    const renderHeight = Math.trunc(height * scale);

    // render with must be multiple of 4
    if (renderWidth % 4 != 0) {
        renderWidth += renderWidth % 4;
    }

    let canvas;
    const inkColor = "#000F55";
    try {
        const image = await mSigObj.renderBitmap(renderWidth, renderHeight, "image/png", 4, inkColor, "white", 0, 0, 0x400000);
        $('#signature64').val(image);
        $('#signature_save_form').submit();
        layoutWrapper.style.pointerEvents = "auto";
        layoutWrapper.style.opacity = "1";
    } catch (e) {
        alert(e);
    }
}

function captureFromCanvas() {
    const config = {};
    config.source = {
        mouse: document.getElementById("allow_mouse_check").checked,
        touch: document.getElementById("allow_touch_check").checked,
        pen: document.getElementById("allow_pen_check").checked
    };

    const sigCaptDialog = new SigCaptDialog(config);

    sigCaptDialog.addEventListener("ok", function () {
        renderSignature();
    });

    console.log(mSigObj)
    sigCaptDialog.open(mSigObj, null, null, null, null, Module.KeyType.SHA512, mHash);
    sigCaptDialog.startCapture();
}

// function captureFromSTU() {
//     const stuDeviceStr = localStorage.getItem("stuDevice");
//     console.log(stuDeviceStr)
//     var stuCapDialog
//     if (stuDeviceStr) {
//         const config = {};
//         stuDevice = JSON.parse(stuDeviceStr);
//         config.stuDevice = stuDevice;
//         stuCapDialog = new StuCaptDialog(config);
//     } else {
//         stuCapDialog = new StuCaptDialog();
//     }
//
//     stuCapDialog.addEventListener("ok", function () {
//         renderSignature();
//     });
//     stuCapDialog.open(mSigObj, null, null, null, null, Module.KeyType.SHA512, mHash);
// }
function setDeviceName() {
    const stuDeviceStr = localStorage.getItem("stuDevice");
    if (stuDeviceStr) {
        document.getElementById("selectedStuDevice").innerHTML = JSON.parse(stuDeviceStr).productName;
    } else {
        document.getElementById("selectedStuDevice").innerHTML = "None";
    }
}

async function encryptSignature() {
    try {
        if (document.getElementById("no_encryption").checked) {
            await mSigObj.setPublicKey("");
            await mSigObj.setPrivateKey("");
        }
    } catch (e) {
        alert(e);
    }
}

async function captureFromSTU() {
    sigCaptDialog = null;
    const config = {};

    if (document.getElementById("encrypt_stu").checked) {
        config.encryption = {
            sessionId: window.crypto.getRandomValues(new Uint32Array(1))[0], // 32 bits random value
            encryptionHandler: new MyEncryptionHandler(), // only necessary if connecting to STU-300/500/520
            encryptionHandler2: new MyEncryptionHandler2(), // only necessary if connection to STU-430/530/540
        };
    }

    const stuDeviceStr = localStorage.getItem("stuDevice");
    let stuDevice;
    if (!stuDeviceStr) {
        const devices = await com.WacomGSS.STU.UsbDevice.requestDevices();
        if (devices.length > 0) {
            stuDevice = devices[0];
            localStorage.setItem("stuDevice", JSON.stringify({
                "vendorId": stuDevice.vendorId,
                "productName": stuDevice.productName,
                "productId": stuDevice.productId
            }));
            setDeviceName();
        } else {
            throw "No STU devices found";
        }
    } else {
        stuDevice = JSON.parse(stuDeviceStr);
        // get all the devices that we have permissions to connect
        await navigator.hid.getDevices().then(devices => {
            devices.forEach(device => {
                if (stuDevice.vendorId === device.vendorId && stuDevice.productId === device.productId && stuDevice.productName === device.productName) {
                    stuDevice = device;
                }
            });
        });
    }

    config.stuDevice = stuDevice;
    stuCapDialog = new StuCaptDialog(config);
    stuCapDialog.addEventListener("ok", function () {
        encryptSignature();
        renderSignature();
    });

    //in this demo we use https://github.com/keithws/browser-report library for getting
    //information about the os.
    const webBrowserData = browserReportSync();
    const osInfo = webBrowserData.os.name + " " + webBrowserData.os.version;
    const nicInfo = "";
    const where = "";
   // stuCapDialog.open(mSigObj, null, null, where, [], Module.KeyType.SHA512, documentHash, osInfo, nicInfo);

    stuCapDialog.open(mSigObj, null, null, null, null, Module.KeyType.SHA512, mHash,osInfo,nicInfo);
}