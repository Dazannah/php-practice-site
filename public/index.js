async function submitHandler() {
  const dataToSend = getDataFromField()
  const isItOkToSend = validateDataToSend(dataToSend)

  if (isItOkToSend) {
    const response = await sendData(dataToSend)
    response.json().then(responsedata => {
      console.log(responsedata)
    })
  }
}

function getDataFromField() {
  const username = document.getElementById("username-input").value
  const password = document.getElementById("password-input").value
  const passwordAgain = document.getElementById("password-input-again").value
  const email = document.getElementById("email-input").value

  return { username, password, passwordAgain, email }
}

function validateDataToSend(dataToSend) {
  const error = []

  if (dataToSend.username === null || dataToSend.username === undefined || dataToSend.username.trim() === "") error.push("You must provide a username.")
  if (dataToSend.password === null || dataToSend.password === undefined || dataToSend.password.trim() === "") error.push("You must provide a password.")
  if (dataToSend.password != dataToSend.passwordAgain) error.push("The two password is different.")

  const passwordRegex = /[A-Z0-9]/
  if (!passwordRegex.test(dataToSend.password)) error.push("At least one upper case letter and a number have to be used in the password")
  if (dataToSend.password.length < 8) error.push("The password have to be at least 8 character long.")

  const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
  if (!emailRegex.test(dataToSend.email)) error.push("You must provide a valid e-mail address.")

  if (error.length > 0) {
    handleError(error)
    return false
  }

  return true
}

async function sendData(dataToSend) {
  const response = fetch("/php-practice-site/php/register.php", {
    method: "POST",
    body: dataToSend
  })

  return response
}

function handleError(error) {
  alert(error)
}
