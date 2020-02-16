import React from 'react';

class Signin extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			email: '',
			password: '',
		};
	}

	_handleSubmit = event => {
		event.preventDefault();
		if (!this._validateForm()) return false;

		this._signinUser();
	};

	_signinUser = () => {
		const data = this.state;
		console.log(data);

		// Send API request
		fetch('http://localhost:8888/api/user/signin', {
			method: 'POST',
			mode: 'no-cors',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(data),
		})
			.then(response => {
				return response.json();
			})
			.then(data => {
				console.log('Success:', data);
			})
			.catch(error => {
				console.error('Error:', error);
			});
	};

	_handleInputChange = event => {
		event.preventDefault();
		this.setState({
			[event.target.name]: event.target.value,
		});
	};

	_validateForm = () => {
		return this._validateEmpty();
	};

	_validateEmpty = () => {
		const stateValues = Object.values(this.state);
		for (const value of stateValues) {
			if (value === '') {
				console.log('Please fill all fields');
				return false;
			}
		}
		return true;
	};

	render() {
		const { email } = this.state;
		const { password } = this.state;

		return (
			<div className="signin">
				<h1>Sign in</h1>
				<form onSubmit={this._handleSubmit}>
					<label htmlFor="email">email</label>
					<input
						name="email"
						value={email}
						onChange={this._handleInputChange}
					/>
					<label htmlFor="password">Password</label>
					<input
						type="password"
						name="password"
						value={password}
						onChange={this._handleInputChange}
					/>
					<button type="submit">Sign in</button>
				</form>
			</div>
		);
	}
}

export default Signin;
