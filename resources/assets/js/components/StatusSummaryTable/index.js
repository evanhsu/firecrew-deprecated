import React, { Component } from 'react';
import ImmutablePropTypes from 'react-immutable-proptypes';
import PropTypes from 'prop-types';
import { fromJS } from 'immutable';
import CrewInfo from './CrewInfo';
import DutyOfficer from './DutyOfficer';
import Timestamp from './Timestamp';
import * as styles from './styles';

const getStatusSummaryTableStyle = () => (
  {
    border: '2px solid black',
    paddingLeft: 0,
    paddingRight: 0,
    minWidth: 800,
  }
);

const getCrewRowStyle = (crewRow) => {
  const style = {
    borderBottom: '2px solid black',
    webkitTransition: '0.5s',
    transition: '0.5s',
  };

  if (crewRow && Moment.utc(crewRow.getIn(['status', 'updated_at'])).add(18, 'hours').isSameOrBefore(Moment.now())) {
    style.backgroundColor = '#fbec5d';
  }
  return style;
};

const getCrewResourceRowStyle = () => (
  {
    borderBottom: '1px dashed gray',
  }
);

const localDateString = (utcDateString) => {
  const localTimeZone = momentTz.tz.guess();
  const localTimeZoneAbbr = momentTz.tz.zone(localTimeZone).abbr(Moment.now());

  return `${Moment.utc(utcDateString).tz(localTimeZone).calendar()} ${localTimeZoneAbbr}`;
};

const renderDispatchPhone = (crew) => (
  crew.get('dispatch_center_24_hour_phone') === null ? null : <span>{crew.get('dispatch_center_name')} 24-hour: {crew.get('dispatch_center_24_hour_phone')}</span>
);

const DispatchCenterRow = ({ crew }) => (
  crew.get('name') ? (
    <span className="col-xs-12" style={{ minHeight: 100 }}>
      <span className="col-xs-7">{renderDispatchPhone(crew)}</span>
      <span className="col-xs-5">Additional notes here</span>
    </span>) : null
);

const HeaderRow = () => (
  <thead>
    <tr>
      <th className="col-xs-2">Crew</th>
      <th className="col-xs-7">
        <span className="col-xs-1" style={{ padding: 0 }}>HRAPS / Surplus</span>
        <span className="col-xs-3">Resource</span>
        <span className="col-xs-3">Location</span>
        <span className="col-xs-5">Notes</span>
      </th>
      <th className="col-xs-3">Intel</th>
    </tr>
  </thead>
);

const CrewRow = ({ crewRow, isSelected, handleClick }) => (
  <tr style={getCrewRowStyle(crewRow)} className={isSelected ? 'bg-primary' : ''} onClick={handleClick(crewRow.get('id'))}>
    <td className="col-xs-2"><span style={{ fontWeight: 'bold' }}>{ crewRow.get('name') }</span><br />
      { crewRow.get('phone') }<br />
      Updated { localDateString(crewRow.getIn(['status', 'updated_at'])) } ({ Moment.utc(crewRow.getIn(['status', 'updated_at'])).fromNow() })
      <CrewInfo crew={crewRow} />
      <DutyOfficer {...crewRow.get('status').toJS()} />
      <Timestamp timestamp={crewRow.get('updated_at')} />
    </td>
    <td
      className="col-xs-7"
      style={{ paddingLeft: 0, paddingRight: 0, borderLeft: '1px dashed gray' }}
    >
      { crewRow.get('statusable_resources').map((resource) => (
        <CrewResourceRow key={resource.get('id')} resource={resource} />
      )) }
      { ['personnel_1_', 'personnel_2_', 'personnel_3_', 'personnel_4_', 'personnel_5_', 'personnel_6_'].map((person) => (
        <CrewPersonnelRow
          key={person}
          person={{
            name: crewRow.getIn(['status', `${person}name`]),
            role: crewRow.getIn(['status', `${person}role`]),
            location: crewRow.getIn(['status', `${person}location`]),
            note: crewRow.getIn(['status', `${person}note`]),
          }}
        />
      )) }
      { isSelected ? <DispatchCenterRow crew={crewRow} /> : null}
    </td>
    <td className="col-xs-3" style={{ borderLeft: '1px dashed black' }}>
      { crewRow.getIn(['status', 'intel']) }
    </td>
  </tr>
);

CrewRow.propTypes = {
  crewRow: ImmutablePropTypes.map,
  isSelected: PropTypes.bool,
};


const CrewResourceRow = ({ resource }) => (
  <span className="col-xs-12" style={styles.getCrewResourceRowStyle()}>
    <span className="col-xs-1">{ `${resource.getIn(['latest_status', 'staffing_value1'])}/${resource.getIn(['latest_status', 'staffing_value2'])}` }</span>
    <span className="col-xs-3">{ resource.get('identifier') } ({ resource.get('model') })</span>
    <span className="col-xs-3">{ resource.getIn(['latest_status', 'assigned_fire_name']) }</span>
    <span className="col-xs-5">
      { resource.getIn(['latest_status', 'manager_name']) && `Contact: ${resource.getIn(['latest_status', 'manager_name'])}` }
      { resource.getIn(['latest_status', 'manager_phone']) && ` (${resource.getIn(['latest_status', 'manager_phone'])})` }<br />
      { resource.getIn(['latest_status', 'comments1']) && `${resource.getIn(['latest_status', 'comments1'])}` }<br />
      { resource.getIn(['latest_status', 'comments2']) }
    </span>
  </span>
);

CrewResourceRow.propTypes = {
  resource: ImmutablePropTypes.map,
};


const CrewPersonnelRow = ({ person }) => (
  person.name ? (
    <span className="col-xs-12" style={ styles.getCrewResourceRowStyle() }>
      <span className="col-xs-1"> </span>
      <span className="col-xs-3">{ person.name }{ person.role && ` [${person.role}]` }</span>
      <span className="col-xs-3">{ person.location }</span>
      <span className="col-xs-5">{ person.note }</span>
    </span>) : null
);

CrewPersonnelRow.propTypes = {
  person: PropTypes.shape({
    name: PropTypes.string,
    role: PropTypes.string,
    location: PropTypes.string,
    note: PropTypes.string,
  }),
};


// const StatusSummaryTable = ({ crews }) => (
class StatusSummaryTable extends Component {
  constructor(props) {
    super(props);
    this.state = {
      selectedCrewRow: null,
    };
  }

  handleCrewRowClick = (crewId) => () => {
    this.setState(prevState => {
      return {
        selectedCrewRow: (prevState.selectedCrewRow === crewId ? null : crewId)
      }
    });
  };

  render() {
    return (
      <HeaderRow />
      <tbody>
      {this.props.crews.map((crew) => (
      <table className="table table-condensed" style={getStatusSummaryTableStyle()}>
        <CrewRow
          key={crew.get('id')}
          crewRow={crew}
          isSelected={parseInt(this.state.selectedCrewRow, 10) === parseInt(crew.get('id'), 10)}
          handleClick={this.handleCrewRowClick}
        />
      ))}
      </tbody>
    </table>);
  }
};

StatusSummaryTable.propTypes = {
  crews: ImmutablePropTypes.list,
};

StatusSummaryTable.defaultProps = {
  crews: fromJS([]),
};

export default StatusSummaryTable;
