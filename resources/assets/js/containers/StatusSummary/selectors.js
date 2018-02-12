import { List } from 'immutable';

const selectSummary = () => (state) => state.getIn(['summary', 'data'], new List());

export { selectSummary };
