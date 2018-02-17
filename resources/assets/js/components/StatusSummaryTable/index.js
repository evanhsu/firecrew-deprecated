import React from 'react';
import ImmutablePropTypes from 'react-immutable-proptypes';
import PropTypes from 'prop-types';
import { fromJS } from 'immutable';
import CrewInfo from './CrewInfo';
import DutyOfficer from './DutyOfficer';
import Timestamp from './Timestamp';
import * as styles from './styles';

const HeaderRow = () => (
  <thead>
    <tr>
      <th className="col-xs-2">Crew</th>
      <th className="col-xs-7">
        <span className="col-xs-1" style={{ padding: 0 }}>HRAP Surplus</span>
        <span className="col-xs-3">Resource</span>
        <span className="col-xs-3">Location</span>
        <span className="col-xs-5">Notes</span>
      </th>
      <th className="col-xs-3">Intel</th>
    </tr>
  </thead>
);

const CrewRow = ({ crewRow }) => (
  <tr style={styles.getCrewRowStyle(crewRow)}>
    <td className="col-xs-2">
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
    </td>
    <td className="col-xs-3" style={{ borderLeft: '1px dashed black' }}>
      { crewRow.getIn(['status', 'intel']) }
    </td>
  </tr>
);

CrewRow.propTypes = {
  crewRow: ImmutablePropTypes.map,
};


const CrewResourceRow = ({ resource }) => (
  <span className="col-xs-12" style={styles.getCrewResourceRowStyle()}>
    <span className="col-xs-1">{ resource.getIn(['latest_status', 'staffing_value2']) }</span>
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


const StatusSummaryTable = ({ crews }) => (
  <table className="table table-condensed table-hover" style={styles.getStatusSummaryTableStyle()}>
    <HeaderRow />
    <tbody>
      { crews.map((crew) => (
        <CrewRow
          key={crew.get('id')}
          crewRow={crew}
        />
      )) }
    </tbody>
  </table>
);

StatusSummaryTable.propTypes = {
  crews: ImmutablePropTypes.list,
};

StatusSummaryTable.defaultProps = {
  crews: fromJS([]),
};

export default StatusSummaryTable;
