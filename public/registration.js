async function registrationHandler() {
  const dataToSend = getDataFromField()
  const isItOkToSend = validateDataToSend(dataToSend)

  if (isItOkToSend) {
    try {
      const response = await sendData(dataToSend)

      const responsedata = await response.text()
      console.log(responsedata)
    } catch (err) {
      console.log(err)
    }
  } else {
    console.log("Error")
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

  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!_])(?!.*\s).{8,}$/
  if (!passwordRegex.test(dataToSend.password)) error.push("At least one upper case letter, a number and a special character have to be used in the password")

  const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
  if (!emailRegex.test(dataToSend.email)) error.push("You must provide a valid e-mail address.")

  if (error.length > 0) {
    handleError(error)
    return false
  }

  return true
}

async function sendData(dataToSend) {
  try {
    let formData = new FormData()
    formData.append("username", dataToSend.username)
    formData.append("password", dataToSend.password)
    formData.append("passwordAgain", dataToSend.passwordAgain)
    formData.append("email", dataToSend.email)

    const response = await fetch("/php-practice-site/php/registration.php", {
      method: "POST",
      body: formData
    })

    return response
  } catch (err) {
    console.log(err)
  }
}

function handleError(error) {
  alert(error)
}
