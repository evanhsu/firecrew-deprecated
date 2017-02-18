import React, { PropTypes, Component } from 'react';
import ReactDOM from 'react-dom';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import RefreshIndicator from 'material-ui/RefreshIndicator';
import InventoryTable from './InventoryTable';

function checkStatus(response) {
  if (response.status >= 200 && response.status < 300) {
    return response
  } else {
    var error = new Error(response.statusText)
    error.response = response
    throw error
  }
}

function parseJSON(response) {
  return response.json()
}


class CategoryTableContainer extends Component {
	constructor(props) {
		super(props);
		this.state = { 
			category: {
				name: null,
				items: [],
			}
		};
	}

	componentDidMount() {
		this.setState({ loading: true });

		fetch('/crew/1/inventory?format=json&category=nomex%20pants', {
			credentials: 'same-origin',
		})
		.then(checkStatus)
		.then(parseJSON)
		.then((data) => {
		    console.log('Get from API succeeded.', data);
			this.setState({ 
				category: data.category,
				loading: false,
			});
		}).catch(function(error) {
			console.log('request failed', error)
		});
	}

	remove = () => {
		let newState = this.state.category.items.slice(1, this.state.category.items.length);
		this.setState({ 
			category: { 
				name: this.state.category.name, 
				items: newState 
			}
		});
	}

	render() {
		return (
			<MuiThemeProvider>
				<div>
					<RefreshIndicator left={100} top={100} status={this.state.loading ? 'loading' : 'hide'} />
					<h1 onClick={ this.remove }>{ this.state.category && this.state.category.name }</h1>
					<InventoryTable items={this.state.category && this.state.category.items} />
				</div>
			</MuiThemeProvider>
		);
	}
}

export default CategoryTableContainer;

