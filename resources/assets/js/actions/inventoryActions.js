import { fromJS } from 'immutable';
// import { Item } from '../objectDefinitions/Item';

export const SELECT_ITEM_CATEGORY = 'SELECT_ITEM_CATEGORY';
export const selectItemCategory = (categoryName) => {
	return {
		type: SELECT_ITEM_CATEGORY,
		categoryName,
	}
}

export const ITEM_ROW_SELECTED = 'ITEM_ROW_SELECTED';
export const itemRowSelected = (row) => {
	return {
		type: ITEM_ROW_SELECTED,
		row,
	}
}

export const ITEM_ROW_DESELECTED = 'ITEM_ROW_DESELECTED';
export const itemRowDeselected = (row, form) => {
	return {
		type: ITEM_ROW_DESELECTED,
	}
}

export const TOGGLE_CATEGORY_MENU_DRAWER = 'TOGGLE_CATEGORY_MENU_DRAWER';
export const toggleCategoryMenuDrawer = () => {
	return {
		type: TOGGLE_CATEGORY_MENU_DRAWER,
	}
}

export const fetchItems = () => {
	// Requires the `redux-thunk` library for making asynchronous calls.
	return function(dispatch) {

		dispatch(requestItems());

		return fetch(`/crew/1/inventory?format=json`, { credentials: "same-origin" })
			.then(response => {
				if(response.status === 200) {
					return response.json();
				} else {
					throw new Error(`Bad HTTP Status: ${response.status}`);
				}
			})
			.then(response => {
				dispatch(receiveItemsSuccess(response.items));
			})	
			.catch(error => {
				console.log(error);
				dispatch(receiveItemsFailure(error));
			});
	}
}

/*
 * Don't call requestItems() directly - it's dispatched from within `fetchItems()`
 */
export const REQUEST_ITEMS = 'REQUEST_ITEMS';
export const requestItems = () => {
	return {
		type: REQUEST_ITEMS,
	}
}

/*
 * Don't call receiveItemsSuccess() directly - it's dispatched from within `fetchItems()`
 */
export const RECEIVE_ITEMS_SUCCESS = 'RECEIVE_ITEMS_SUCCESS';
export const receiveItemsSuccess = (items) => {
	return {
		type: RECEIVE_ITEMS_SUCCESS,
		items: fromJS(items),
	};
}

export const RECEIVE_ITEMS_FAILURE = 'RECEIVE_ITEMS_FAILURE';
export const receiveItemsFailure = (error) => {
	return {
		type: RECEIVE_ITEMS_FAILURE,
		error,
	}
}

export const INVALIDATE_ITEM_CATEGORIES = 'INVALIDATE_ITEM_CATEGORIES';
export const invalidateItemCategories = () => {
	return {
		type: INVALIDATE_ITEM_CATEGORIES,
	}
}

/*
 * Don't call requestItemCategory() directly - it's dispatched from within `fetchItemCategory()`
 */
export const REQUEST_ITEM_CATEGORY = 'REQUEST_ITEM_CATEGORY';
export const requestItemCategory = (categoryName) => {
	return {
		type: REQUEST_ITEM_CATEGORY,
		categoryName,
	}
}

/*
 * Don't call receiveItemCategory() directly - it's dispatched from within `fetchItemCategory()`
 */
export const RECEIVE_ITEM_CATEGORY = 'RECEIVE_ITEM_CATEGORY';
export const receiveItemCategory = (categoryName, json) => {
	return {
		type: RECEIVE_ITEM_CATEGORY,
		categoryName,
		items: json.category.items,
		receivedAt: Date.now(),
	}
}

export const INVALIDATE_ITEM_CATEGORY = 'INVALIDATE_ITEM_CATEGORY';
export const invalidateItemCategory = (categoryName) => {
	return {
		type: INVALIDATE_ITEM_CATEGORY,
		categoryName
	}
}

export const fetchItemCategory = (categoryName) => {
	// Requires the `redux-thunk` library for making asynchronous calls.
	return function(dispatch) {

		dispatch(requestItemCategory(categoryName));

		return fetch(`/crew/1/inventory?format=json&category=${categoryName}`, { credentials: "same-origin" })
			.then(response => response.json())
			.then(json =>
				dispatch(receiveItemCategory(categoryName, json))
			)
	}
}

export const decrementItem = (category, itemId) => {
	return function(dispatch) {

		dispatch(decrementItemRequest(category, itemId));

		return fetch(`/item/${itemId}/decrement`, { 
			method: 'post',
			credentials: 'same-origin'
		}).then(response => {
			if(response.status == 204) {
				dispatch(decrementItemSucess(itemId));
			} else {
				dispatch(decrementItemFailure(category, itemId));
			}
		}).catch(error => dispatch(decrementItemFailure(category, itemId)));
	}
}

export const DECREMENT_ITEM_REQUEST = 'DECREMENT_ITEM_REQUEST';
export const decrementItemRequest = (category, itemId) => {
	return {
		type: DECREMENT_ITEM_REQUEST,
		itemId,
		category,
	}
}

export const DECREMENT_ITEM_SUCCESS = 'DECREMENT_ITEM_SUCCESS';
export const decrementItemSuccess = (itemId) => {
	return {
		type: DECREMENT_ITEM_SUCCESS,
		itemId,
	}
}

export const DECREMENT_ITEM_FAILURE = 'DECREMENT_ITEM_FAILURE';
export const decrementItemFailure = (category, itemId) => {
	return {
		type: DECREMENT_ITEM_FAILURE,
		itemId,
		category,
	}
}

export const incrementItem = (category, itemId) => {
	return function(dispatch) {

		dispatch(incrementItemRequest(category, itemId));

		return fetch(`/item/${itemId}/increment`, { 
			method: 'post',
			credentials: 'same-origin'
		}).then(response => {
			if(response.status == 204) {
				dispatch(incrementItemSucess(itemId));
			} else {
				dispatch(incrementItemFailure(category, itemId));
			}
		}).catch(error => dispatch(incrementItemFailure(category, itemId)));
	}
}

export const INCREMENT_ITEM_REQUEST = 'INCREMENT_ITEM_REQUEST';
export const incrementItemRequest = (category, itemId) => {
	return {
		type: INCREMENT_ITEM_REQUEST,
		itemId,
		category,
	}
}

export const INCREMENT_ITEM_SUCCESS = 'INCREMENT_ITEM_SUCCESS';
export const incrementItemSuccess = (itemId) => {
	return {
		type: INCREMENT_ITEM_SUCCESS,
		itemId,
	}
}

export const INCREMENT_ITEM_FAILURE = 'INCREMENT_ITEM_FAILURE';
export const incrementItemFailure = (category, itemId) => {
	return {
		type: INCREMENT_ITEM_FAILURE,
		itemId,
		category,
	}
}

// export const EXPAND_TABLE_ROW = 'EXPAND_TABLE_ROW';
// export const expandTableRow = (rows) => {
// 	return {
// 		type: EXPAND_TABLE_ROW,
// 		rows,
// 	}
// }


// export const SET_BOTTOM_DRAWER_STATE = 'SET_BOTTOM_DRAWER_STATE';
// export const setBottomDrawerState = (open) => {
// 	return {
// 		type: SET_BOTTOM_DRAWER_STATE,
// 		open,
// 	}
// }
