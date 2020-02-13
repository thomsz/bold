import React from 'react';
import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';
import Signup from './views/signup';
import Signin from './views/signin';

function App() {
	return (
		<Router>
			<Switch>
				<Route path="/signup">
					<Signup />
				</Route>
				<Route path="/signin">
					<Signin />
				</Route>
				<Route path="/">
					<Home />
				</Route>
			</Switch>
		</Router>
	);
}

export default App;

function Home() {
	return <div>Welcome home</div>;
}
