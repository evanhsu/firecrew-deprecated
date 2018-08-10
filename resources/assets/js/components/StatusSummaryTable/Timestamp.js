import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Moment from 'moment';
import momentTz from 'moment-timezone';

const localDateString = (utcDateString) => {
  const localTimeZone = momentTz.tz.guess();
  const localTimeZoneAbbr = momentTz.tz.zone(localTimeZone).abbr(Moment.now());

  return `${Moment.utc(utcDateString).tz(localTimeZone).calendar()} ${localTimeZoneAbbr}`;
};

class Timestamp extends Component {
  constructor(props) {
    super(props);

    this.state = {
      timeString: props.timestamp === undefined ? null : localDateString(props.timestamp),
      relativeTime: props.timestamp === undefined ? '' : Moment.utc(props.timestamp).fromNow(),
    }
  }

  componentDidMount() {
    this.timeout();
  }

  timeout() {
    setTimeout(() => this.updateRelativeTime(), 10000);
  }

  updateRelativeTime = () => {
    this.setState({
      relativeTime: props.timestamp === undefined ? '' : Moment.utc(props.timestamp).fromNow(),
    })
  };

  render() {
    if(props.timestamp === null) {
      return null;
    }

    return (<span style={{ fontSize: 11 }}>Update: {this.state.timeString} ({this.state.relativeTime})</span>);

  }
}

Timestamp.propTypes = {
  timestamp: PropTypes.node,
};
Timestamp.defaultProps = {
  timestamp: null,
};

export default Timestamp;
