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
    transition: 'background-color 100ms ease-in, color 100ms ease-in',
  };

  if (props.crewRow && Moment.utc(props.crewRow.get('updated_at')).add(18, 'hours').isSameOrBefore(Moment.now())) {
    style.backgroundColor = '#fbec5d';
  }
  return style;
};

export const getCrewResourceRowStyle = () => (
  {
    borderBottom: '1px dashed gray',
  }
);
