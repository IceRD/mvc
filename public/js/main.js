let checkValidation = {
	
	email(){
		const el = event.currentTarget;

		if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(el.value)) {
			el.classList.add('is-invalid');
			el.nextElementSibling.textContent = "the email address is invalid form";
		} else {
			el.classList.remove('is-invalid');
			el.nextElementSibling.textContent = "";
		}
	},

	text(){
		const el = event.currentTarget;

		if (!/^[\wА-я_]{1,}$/.test(el.value)) {
			el.classList.add('is-invalid');
			el.nextElementSibling.textContent = "minimum length 1 characters";
		} else {
			el.classList.remove('is-invalid');
			el.nextElementSibling.textContent = "";
		}
	}

}