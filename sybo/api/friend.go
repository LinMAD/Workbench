package api

import (
	"encoding/json"
	"fmt"
	"net/http"
)

const storageFriendPostfix = "friend"

// FriendList
type FriendList struct {
	// Friends list with user UUID
	Friends []UUID `json:"friends"`
}

// friend list endpoint handler
func (api *API) friend(w http.ResponseWriter, r *http.Request) {
	var requesterUUID UUID
	if r.Method == "PUT" || r.Method == "GET" {
		isExistUUID := api.checkIfUserExist(w, r)
		if isExistUUID == nil {
			return
		}

		requesterUUID = *isExistUUID
	}

	switch r.Method {
	case "PUT":
		var friendList FriendList
		if err := json.NewDecoder(r.Body).Decode(&friendList); err != nil {
			api.errorResponse(w, fmt.Errorf("%s", "Invalid request payload"), http.StatusBadRequest)

			return
		}

		api.Storage.Add(string(requesterUUID)+storageFriendPostfix, friendList)
		api.successResponse(w, http.StatusAccepted, SuccessResponse{Message: "Accepted"})
	case "GET":
		friendList := api.Storage.Get(string(requesterUUID + storageFriendPostfix))
		if friendList == nil {
			api.errorResponse(w, fmt.Errorf("%s", "Friend list not found"), http.StatusNotFound)

			return
		}

		api.successResponse(w, http.StatusOK, friendList)
	default:
		api.invalidHTTPMethod(w)
	}
}
