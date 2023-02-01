let socketClient = io("127.0.0.1:9000");
var dataOnline;
let userIdOnline = document.getElementById("info-user-online").getAttribute("data-key");
socketClient.emit("user-online", {
    userId : userIdOnline
});
var observeDOM = (function () {
    var MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

    return function (obj, callback) {
        if (!obj || obj.nodeType !== 1) return;

        if (MutationObserver) {
            // define a new observer
            var mutationObserver = new MutationObserver(callback)

            // have the observer observe foo for changes in children
            mutationObserver.observe(obj, {childList: true, subtree: true})
            return mutationObserver
        }

        // browser support fallback
        else if (window.addEventListener) {
            obj.addEventListener('DOMNodeInserted', callback, false)
            obj.addEventListener('DOMNodeRemoved', callback, false)
        }
    }
})()
socketClient.on("notify-online", (data) => {
    console.log(data);
    let keys = Object.keys(data);
    dataOnline = data;
    let userDiv = document.getElementById("id-user-of-shop");
    if (userDiv) {
        let userId = userDiv.getAttribute("data-key");
        if (!keys.includes(userId)) {
            let btnChat = document.getElementById('button-chat-user-shop')
            if (btnChat) {
                btnChat.classList.add("d-none");
            }
            $("#chatShop").modal("hide");
            console.log("shop ko online");
        } else {
            let btnChat = document.getElementById('button-chat-user-shop')
            if (btnChat) {
                btnChat.classList.remove("d-none");
            }
            // $("#chatShop").modal("show");
            console.log("shop online");
        }
    }
});

let listChat = document.getElementById("list-chat");
let chatContent = document.getElementById("frame-chat-left");

observeDOM(listChat, function (m) {
    var addedNodes = [], removedNodes = [];

    m.forEach(record => record.addedNodes.length & addedNodes.push(...record.addedNodes))

    m.forEach(record => record.removedNodes.length & removedNodes.push(...record.removedNodes))

    // console.clear();
    console.log('Added:', addedNodes, 'Removed:', removedNodes);
});

observeDOM(chatContent, function (m) {
    var addedNodes = [], removedNodes = [];

    m.forEach(record => record.addedNodes.length & addedNodes.push(...record.addedNodes))

    m.forEach(record => record.removedNodes.length & removedNodes.push(...record.removedNodes))

    // console.clear();
    console.log('Added:', addedNodes, 'Removed:', removedNodes);
});

// giu
listChat.onclick = function (e) {
    console.log(e.target.className);
    if (e.target.nodeName == "DIV" && e.target.className == "list-chat-item") {
        let arrayContentOfUser = document.getElementsByClassName("content-of-user");
        for (let contentOfUser of arrayContentOfUser) {
            if (contentOfUser.id == "content-of-user-" + e.target.id.split("-")[3]) {
                contentOfUser.classList.remove("d-none")
            } else {
                contentOfUser.classList.add("d-none")
            }
        }
        let contentDefault = document.getElementById("content-of-user-default");
        contentDefault.classList.add(("d-none"));
    }
}
// end giu

///////////////////////////////////////////////////////////////////////////////////////////
let iconsChatSmall = document.getElementsByClassName("chat-small");
if (iconsChatSmall) {
    for (let iconChatSmall of iconsChatSmall) {
        iconChatSmall.onclick = (e) => {
            e.preventDefault();
            let frame = document.getElementById("chat-list-frame-tag-id");
            if (frame.classList.contains("d-none")) {
                frame.classList.remove("d-none");
            } else {
                frame.classList.add("d-none");
            }
        }
    }
}

let btnChatNow = document.getElementById("button-chat-user-shop");
if (btnChatNow) {
    btnChatNow.onclick = function (e) {
        e.preventDefault();
        let frame = document.getElementById("chat-list-frame-tag-id");
        if (frame.classList.contains("d-none")) {
            frame.classList.remove("d-none");
            let userId = document.getElementById("id-user-of-shop").getAttribute("data-key");
            let itemUser = document.getElementById("list-chat-item-" + userId);
            if (itemUser) {
                let frameChatLeft = document.getElementById("content-of-user-" + userId);
                if (frameChatLeft) {
                    let frameChatContent = frameChatLeft.children[1];
                    let itemReceive = document.createElement("div");
                    itemReceive.setAttribute("class", "chat-content-user-receive");
                    let pReceive = document.createElement("p");
                    pReceive.setAttribute("class", "chat-receive-content");
                    pReceive.textContent = content;
                    itemReceive.appendChild(pReceive);
                    frameChatContent.appendChild(itemReceive);
                }
            }
            else {
                let item = document.createElement("div");
                item.setAttribute("id", "list-chat-item-" + userId);
                item.setAttribute("class", "list-chat-item");
                let shopName = document.getElementById("shop-name-" + userId).textContent;
                // console.log("shop id la" + userId);
                item.textContent = shopName;
                let frameListChat = document.getElementById("list-chat");
                frameListChat.appendChild(item);

                let frameChatLeft = document.getElementById("frame-chat-left");

                let contentFrameChat = document.createElement("div");
                contentFrameChat.setAttribute("id", "content-of-user-" + userId);
                contentFrameChat.setAttribute("class", "content-of-user");

                let chatContentTop = document.createElement("div",)
                chatContentTop.setAttribute("class", "chat-content-top");
                let avatarChat = document.createElement("div");
                avatarChat.setAttribute("class", "avatar-chat");
                let imgAvatar = document.createElement("img");
                let shopAvatar = document.getElementById("shop-avatar-" + userId);
                imgAvatar.setAttribute("src", shopAvatar.src);
                imgAvatar.style.cssText = "width: 100%; height: 100%;";
                avatarChat.appendChild(imgAvatar);
                let spanName = document.createElement("span");
                spanName.textContent = shopName;
                chatContentTop.appendChild(avatarChat);
                chatContentTop.appendChild(spanName);

                let chatContentUser = document.createElement("div");
                chatContentUser.setAttribute("class", "chat-content-user");
                let chatContentUserSend = document.createElement("div");


                let chatContentBottom = document.createElement("div");
                chatContentBottom.setAttribute("class", "chat-content-bottom");
                chatContentBottom.style.display = "flex";
                let inputFill = document.createElement("input");
                inputFill.setAttribute("type", "text");
                inputFill.setAttribute("id", "chat-reply-" + userId);
                inputFill.style.width = "90%";
                let buttonChatReply = document.createElement("div");
                buttonChatReply.setAttribute("class", "button-chat-reply");
                buttonChatReply.style.cssText = "width: 10%; cursor: pointer";
                let iconSend = document.createElement("i");
                iconSend.setAttribute("class", "fa fa-paper-plane");
                iconSend.setAttribute("aria-hidden", "true");
                buttonChatReply.appendChild(iconSend);
                chatContentBottom.appendChild(inputFill);
                chatContentBottom.appendChild(buttonChatReply);

                contentFrameChat.appendChild(chatContentTop);
                contentFrameChat.appendChild(chatContentUser);
                contentFrameChat.appendChild(chatContentBottom);
                // contentFrameChat.classList.add("d-none");
                let defaultContent = document.getElementById("content-of-user-default");
                defaultContent.classList.add("d-none");

                frameChatLeft.appendChild(contentFrameChat);
            }
        } else {
            frame.classList.add("d-none");
        }
    }
}

chatContent.onclick = function (e) {
    let buttonsReply = document.getElementsByClassName("button-chat-reply");

    if (buttonsReply) {
        for (let buttonReply of buttonsReply) {
            buttonReply.onclick = function () {
                let parent = this.parentElement;
                let inputReply = parent.children[0];
                let partnerId = inputReply.id.split("-")[2];
                let content = inputReply.value;
                let tagInfoUserSend = document.getElementById("info-user-online");

                let frameChat = parent.parentElement.children[1];
                console.log("id la" + partnerId);
                console.log("socket la: " + dataOnline[partnerId]);
                if (dataOnline[partnerId]) {
                    console.log("vao day");
                    socketClient.emit("private-message", {
                        to: dataOnline[partnerId],
                        content: content,
                        info: tagInfoUserSend.getAttribute("data-info")
                    })

                    let sendChat = document.createElement("div");
                    sendChat.classList.add("chat-content-user-send");
                    let messageChat = document.createElement("p");
                    messageChat.classList.add("chat-send-content");
                    messageChat.textContent = content;
                    sendChat.appendChild(messageChat);
                    frameChat.appendChild(sendChat);

                    inputReply.value = "";
                }
            }
        }
    }
}

socketClient.on("private-message", ({content, info}) => {
    console.log("noi dung nhan duoc la: " + content);
    console.log("id nguoi gui cho ban: " + info);
    let dataUserReceive = info.split('-');
    let itemUser = document.getElementById("list-chat-item-" + dataUserReceive[0]);
    if (itemUser) {
        let frameChatLeft = document.getElementById("content-of-user-" + dataUserReceive[0]);
        if (frameChatLeft) {
            let frameChatContent = frameChatLeft.children[1];
            let itemReceive = document.createElement("div");
            itemReceive.setAttribute("class", "chat-content-user-receive");
            let pReceive = document.createElement("p");
            pReceive.setAttribute("class", "chat-receive-content");
            pReceive.textContent = content;
            itemReceive.appendChild(pReceive);
            frameChatContent.appendChild(itemReceive);
        }
    }
    else {
        let item = document.createElement("div");
        item.setAttribute("id", "list-chat-item-" + dataUserReceive[0]);
        item.setAttribute("class", "list-chat-item");
        item.textContent = dataUserReceive[1];
        let frameListChat = document.getElementById("list-chat");
        frameListChat.appendChild(item);

        let frameChatLeft = document.getElementById("frame-chat-left");

        let contentFrameChat = document.createElement("div");
        contentFrameChat.setAttribute("id", "content-of-user-" + dataUserReceive[0]);
        contentFrameChat.setAttribute("class", "content-of-user");

        let chatContentTop = document.createElement("div",)
        chatContentTop.setAttribute("class", "chat-content-top");
        let avatarChat = document.createElement("div");
        avatarChat.setAttribute("class", "avatar-chat");
        let imgAvatar = document.createElement("img");
        imgAvatar.setAttribute("src", dataUserReceive[2]);
        imgAvatar.style.cssText = "width: 100%; height: 100%;";
        avatarChat.appendChild(imgAvatar);
        let spanName = document.createElement("span");
        spanName.textContent = dataUserReceive[1];
        chatContentTop.appendChild(avatarChat);
        chatContentTop.appendChild(spanName);

        let chatContentUser = document.createElement("div");
        chatContentUser.setAttribute("class", "chat-content-user");
        let chatContentUserReceive = document.createElement("div");
        chatContentUserReceive.setAttribute("class", "chat-content-user-receive");
        let chatReceiveContent = document.createElement("p");
        chatReceiveContent.setAttribute("class", "chat-receive-content");
        chatReceiveContent.textContent = content;
        chatContentUserReceive.appendChild(chatReceiveContent);
        chatContentUser.appendChild(chatContentUserReceive);

        let chatContentBottom = document.createElement("div");
        chatContentBottom.setAttribute("class", "chat-content-bottom");
        chatContentBottom.style.display = "flex";
        let inputFill = document.createElement("input");
        inputFill.setAttribute("type", "text");
        inputFill.setAttribute("id", "chat-reply-" + dataUserReceive[0]);
        inputFill.style.width = "90%";
        let buttonChatReply = document.createElement("div");
        buttonChatReply.setAttribute("class", "button-chat-reply");
        buttonChatReply.style.cssText = "width: 10%; cursor: pointer";
        let iconSend = document.createElement("i");
        iconSend.setAttribute("class", "fa fa-paper-plane");
        iconSend.setAttribute("aria-hidden", "true");
        buttonChatReply.appendChild(iconSend);
        chatContentBottom.appendChild(inputFill);
        chatContentBottom.appendChild(buttonChatReply);

        contentFrameChat.appendChild(chatContentTop);
        contentFrameChat.appendChild(chatContentUser);
        contentFrameChat.appendChild(chatContentBottom);
        contentFrameChat.classList.add("d-none");

        frameChatLeft.appendChild(contentFrameChat);
    }
})
