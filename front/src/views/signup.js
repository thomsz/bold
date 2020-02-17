import React from 'react';

class Signup extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			email: '',
			password: '',
			repeatPassword: '',
		};
	}

	_handleSubmit = event => {
		event.preventDefault();

		if (!this._validateForm()) return false;

		this._addUser();
	};

	_addUser = () => {
		const data = this.state;

		// Send API request
		fetch('http://localhost:8888/api/user/new', {
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
		return this._validateEmpty() && this._validatePasswordConfirmation();
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

	_validatePasswordConfirmation = () => {
		if (this.state.password !== this.state.repeatPassword) {
			console.log('Please confirm your password');
			return false;
		}
		return true;
	};

	render() {
		const { email } = this.state;
		const { password } = this.state;
		const { repeatPassword } = this.state;

		return (
			<div className="signup">
				<h1>Sign up</h1>
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
					<label htmlFor="repeatPassword">Confirm password</label>
					<input
						type="password"
						name="repeatPassword"
						value={repeatPassword}
						onChange={this._handleInputChange}
					/>
					<button type="submit">Sign up</button>
				</form>
			</div>
		);
	}
}

export default Signup;
