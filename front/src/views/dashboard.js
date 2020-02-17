import React from 'react';

class Dashboard extends React.Component {
	render() {
		return (
			<div className="dashboard">
				<h1>Welcome to the Dashboard: {this.props.user.email}</h1>
			</div>
		);
	}
}

export default Dashboard;
