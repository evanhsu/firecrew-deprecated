import Immutable, { fromJS } from 'immutable';
import { 
	SELECT_ITEM_CATEGORY,
	TOGGLE_CATEGORY_MENU_DRAWER,
	REQUEST_ITEMS,
	RECEIVE_ITEMS_SUCCESS,
	RECEIVE_ITEMS_FAILURE,
	ITEM_ROW_SELECTED,
	ITEM_ROW_DESELECTED,
	DECREMENT_ITEM_REQUEST,
	DECREMENT_ITEM_SUCCESS,	
	DECREMENT_ITEM_FAILURE,	
	INCREMENT_ITEM_REQUEST,
	INCREMENT_ITEM_SUCCESS,	
	INCREMENT_ITEM_FAILURE,
} from '../actions/inventoryActions';

function category(state = { isFetching: false, didInvalidate: false, items: [] }, action) {
	switch(action.type) {
		case RECEIVE_ITEM_CATEGORY:
			return Object.assign({}, state, {
				items: action.items,
				isFetching: false,
				didInvalidate: false,
				lastUpdated: action.receivedAt,
			});
		case REQUEST_ITEM_CATEGORY:
			return Object.assign({}, state, {
				isFetching: true,
				didInvalidate: false,
			});
		case INVALIDATE_ITEM_CATEGORY:
			return Object.assign({}, state, {
				didInvalidate: true,
			});
		default:
			return state;
	}
}

export function itemCategories(state = Immutable.Map(), action) {
	switch(action.type) {
		case RECEIVE_ITEM_CATEGORY:
			return fromJS(
				Object.assign({}, state, {
					[action.categoryName]: category(state[action.categoryName], action)
				})
			);
		case RECEIVE_ITEM_CATEGORIES:
			return fromJS(action.categories); // REPLACE the entire state.itemCategories
		case DECREMENT_ITEM_REQUEST:
			return state;
		default:
			return state;
	}
}

// export function items(state = {}, action) {
// 	switch(action.type) {
// 		case RECEIVE_ITEM_CATEGORY:
// 			return fromJS(
// 				Object.assign({}, state, {
// 					[action.categoryName]: category(state[action.categoryName], action)
// 				})
// 			);
// 		case RECEIVE_ITEM_CATEGORIES:
// 			return fromJS(action.categories); // REPLACE the entire state.itemCategories
// 		case DECREMENT_ITEM_REQUEST:
// 			return Object.assign()
// 		default:
// 			return state;
// 	}
// }

export function selectedItemCategory(state = '', action) {
	switch(action.type) {
		case SELECT_ITEM_CATEGORY:
			return action.categoryName;
		default:
			return state;
	}
}

export function categoryMenuDrawerOpen(state = false, action) {
	switch(action.type) {
		case TOGGLE_CATEGORY_MENU_DRAWER:
			return !state;
		case SELECT_ITEM_CATEGORY:
			return false;
		default:
			return state;
	}
}

export function selectedItemRow(state = null, action) {
	switch(action.type) {
		case ITEM_ROW_SELECTED:
			return action.row === state ? state : action.row;
		case ITEM_ROW_DESELECTED:
			return null;
		default:
			return state;
	}
}

