import React from 'react';
import ImmutablePropTypes from 'react-immutable-proptypes';
import PropTypes from 'prop-types';
import { fromJS } from 'immutable';
import Moment from 'moment';
import momentTz from 'moment-timezone';

const getStatusSummaryTableStyle = () => (
  {
    border: '2px solid black',
    paddingLeft: 0,
    paddingRight: 0,
  }
);

const getHeaderRowStyle = () => (
  {
    borderBottom: '2px solid black',
    fontWeight: 'bold',
  }
);

const getCrewRowStyle = (crewRow) => {
  const style = {
    borderBottom: '2px solid black',
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

const HeaderRow = () => (
  <div className="col-xs-12" style={getHeaderRowStyle()}>
    <span className="col-xs-2">Crew</span>
    <span className="col-xs-7">
      <span className="col-xs-1">HRAP Surplus</span>
      <span className="col-xs-3">Resource</span>
      <span className="col-xs-3">Location</span>
      <span className="col-xs-5">Notes</span>
    </span>
    <span className="col-xs-3">Intel</span>
  </div>
);

const CrewRow = ({ crewRow }) => (
  <div className="col-xs-12" style={getCrewRowStyle(crewRow)}>
    <span className="col-xs-2">
      <span style={{ fontWeight: 'bold' }}>{crewRow.get('name')}</span><br />
      {crewRow.get('phone')}<br />
      Updated {localDateString(crewRow.getIn(['status', 'updated_at']))} ({Moment.utc(crewRow.getIn(['status', 'updated_at'])).fromNow()})
    </span>
    <span className="col-xs-7" style={{ paddingLeft: 0, paddingRight: 0, borderLeft: '1px dashed gray' }}>
      {crewRow.get('statusable_resources').map((resource) => (
        <CrewResourceRow key={resource.get('id')} resource={resource} />
      ))}
      {['personnel_1_', 'personnel_2_', 'personnel_3_', 'personnel_4_', 'personnel_5_', 'personnel_6_'].map((person) => (
        <CrewPersonnelRow
          key={person}
          person={{
            name: crewRow.getIn(['status', `${person}name`]),
            role: crewRow.getIn(['status', `${person}role`]),
            location: crewRow.getIn(['status', `${person}location`]),
            note: crewRow.getIn(['status', `${person}note`]),
          }}
        />
      ))}
    </span>
    <span className="col-xs-3" style={{ borderLeft: '1px dashed black' }}>
      {crewRow.getIn(['status', 'intel'])}
    </span>
  </div>
);

CrewRow.propTypes = {
  crewRow: ImmutablePropTypes.map,
};


const CrewResourceRow = ({ resource }) => (
  <span className="col-xs-12" style={getCrewResourceRowStyle()}>
    <span className="col-xs-1">{resource.getIn(['latest_status', 'staffing_value1'])}</span>
    <span className="col-xs-3">{resource.get('identifier')} ({resource.get('model')})</span>
    <span className="col-xs-3">{resource.getIn(['latest_status', 'assigned_fire_name'])}</span>
    <span className="col-xs-5">
      {resource.getIn(['latest_status', 'manager_name']) && `Contact: ${resource.getIn(['latest_status', 'manager_name'])}`}
      {resource.getIn(['latest_status', 'manager_phone']) && ` (${resource.getIn(['latest_status', 'manager_phone'])})`}<br />
      {resource.getIn(['latest_status', 'comments1']) && `${resource.getIn(['latest_status', 'comments1'])}`}<br />
      {resource.getIn(['latest_status', 'comments2'])}
    </span>
  </span>
);

CrewResourceRow.propTypes = {
  resource: ImmutablePropTypes.map,
};


const CrewPersonnelRow = ({ person }) => (
  person.name ? (
    <span className="col-xs-12" style={getCrewResourceRowStyle()}>
      <span className="col-xs-1"> </span>
      <span className="col-xs-3">{person.name}{person.role && ` [${person.role}]`}</span>
      <span className="col-xs-3">{person.location}</span>
      <span className="col-xs-5">{person.note}</span>
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


const StatusSummaryTable = ({ crews }) => (
  <div className="col-xs-12" style={getStatusSummaryTableStyle()}>
    <HeaderRow />
    {crews.map((crew) => (
      <CrewRow
        key={crew.get('id')}
        crewRow={crew}
      />
    ))}
  </div>
);

StatusSummaryTable.propTypes = {
  crews: ImmutablePropTypes.list,
};

StatusSummaryTable.defaultProps = {
  crews: fromJS([]),
};

export default StatusSummaryTable;
