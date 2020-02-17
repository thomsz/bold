import React from 'react';
import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';
import Signup from './views/signup';
import Signin from './views/signin';
import Dashboard from './views/dashboard';

function Public() {
	return (
		<>
			<Route path="/signup">
				<Signup />
			</Route>
			<Route path="/signin">
				<Signin />
			</Route>
		</>
	);
}

function Protected(props) {
	return (
		<Route path="/dashboard">
			<Dashboard user={props.user} />
		</Route>
	);
}

function App() {
	return (
		<Router>
			<Switch>
				<Auth />
				<Route path="/">
					<Home />
				</Route>
			</Switch>
		</Router>
	);
}

class Auth extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			loggedIn: false,
			user: {
				email: '',
			},
		};
	}

	componentDidMount() {
		const token = localStorage.getItem('token');
		console.log(token);
		if (token)
			fetch('http://localhost:8888/api/user/info', {
				method: 'POST',
				body: JSON.stringify({ token }),
			})
				.then(res => res.json())
				.then(data => {
					console.log(data);
					if (data.success)
						this.setState({
							loggedIn: true,
							user: {
								email: data.email,
							},
						});
				});
	}

	render() {
		if (this.state.loggedIn) {
			return <Protected user={this.state.user} />;
		}

		return <Public />;
	}
}

export default App;

function Home() {
	return <div>Welcome home</div>;
}
