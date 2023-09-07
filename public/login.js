// /php-practice-site/php/login.php

async function loginHandler() {
  const dataToSend = getDataFromFields()
  const response = await sendData(dataToSend)
}

function getDataFromFields() {
  const username = document.getElementById("username").value
  const password = document.getElementById("password").value

  return { username, password }
}

async function sendData(dataToSend) {
  let formData = new FormData()
  formData.append("username", dataToSend.username)
  formData.append("password", dataToSend.password)

  const response = await fetch("/php-practice-site/php/login.php", {
    method: "POST",
    body: formData
  })

  const jsonResponse = await response.json()
  console.log(jsonResponse.status)
  if (jsonResponse.status === true) {
    window.location.href = "/php-practice-site/php/home.php"
  }
}
