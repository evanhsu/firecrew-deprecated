import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import InventoryTable from './InventoryTable';

const items = [
	{
		id: 1,
		serialNumber: 'src-04',
		category: 'Sleeping Bag',
		description: 'North face cats meow',
	},
	{
		id: 2,
		serialNumber: 'src-06',
		category: 'Sleeping Bag',
		description: 'North face cats meow',
	},	
	{
		id: 3,
		serialNumber: 'src-07',
		category: 'Sleeping Bag',
		description: 'North face cats meow',
	},
	{
		id: 4,
		serialNumber: 'fh09',
		category: 'Flight Helmet',
		description: 'SPH-5',
	},
	{
		id: 5,
		serialNumber: 'fh23',
		category: 'Flight Helmet',
		description: 'SPH-5',
	},
];


const Example = () => (
    <MuiThemeProvider>
    	<InventoryTable items={items} />
	</MuiThemeProvider>
)

// We only want to try to render our component on pages that have a div with an ID
// of "example"; otherwise, we will see an error in our console 
if (document.getElementById('example')) {
    ReactDOM.render(
    	<Example />,
    	document.getElementById('example')
	);
}
