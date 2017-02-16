import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Example extends Component {
    render() {
        return (
            <div>
                <h1>Quantity: {this.props.quantity}</h1>
            </div>
        );
    }
}

export default Example;


// We only want to try to render our component on pages that have a div with an ID
// of "example"; otherwise, we will see an error in our console 
if (document.getElementById('example')) {
    ReactDOM.render(
    	<Example quantity={3} />,
    	document.getElementById('example')
	);
}
