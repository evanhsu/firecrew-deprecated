import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import CategoryTableContainer from './CategoryTableContainer';

const Example = () => (
	<CategoryTableContainer />
)

Array.prototype.forEach.call(
  document.getElementsByClassName('example'),
  function(el) {
  	console.log(el);
    ReactDOM.render(
      <Example />,
      el
    )
  }
)

