import React from 'react';
import PropTypes from 'prop-types';

const DutyOfficer = (props) => {
  if(props.duty_officer_name && props.duty_officer_phone) { 
    return (
      <span>
        <b>Duty Officer:</b><br />
        {props.duty_officer_name}<br />
        {props.duty_officer_phone}<br />
      </span>
    );
  }
  if(props.duty_officer_name) {
    return (
      <span>
        <b>Duty Officer:</b><br />
        {props.duty_officer_name}<br />
      </span>
    );
  }
  if(props.duty_officer_phone) {
    return (
      <span>
        <b>Duty Officer:</b><br />
        {props.duty_officer_phone}<br />
      </span>
    );
  }
  return null;
};

DutyOfficer.propTypes = {
  duty_officer_name: PropTypes.string,
  duty_officer_phone: PropTypes.string,
};

export default DutyOfficer;