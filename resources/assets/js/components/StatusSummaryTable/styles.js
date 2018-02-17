import Moment from 'moment';

export const getStatusSummaryTableStyle = () => (
  {
    border: '2px solid black',
    paddingLeft: 0,
    paddingRight: 0,
    minWidth: 800,
  }
);

export const getCrewRowStyle = (props) => {
  const style = {
    borderBottom: '2px solid black',
    // WebkitTransition: '0.25s',
    // transition: '0.25s',
  };

  if (props.crewRow && Moment.utc(props.crewRow.getIn(['status', 'updated_at'])).add(18, 'hours').isSameOrBefore(Moment.now())) {
    style.backgroundColor = '#fbec5d';
  }
  return style;
};

export const getCrewResourceRowStyle = () => (
  {
    borderBottom: '1px dashed gray',
  }
);
