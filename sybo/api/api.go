package api

import (
	"encoding/json"
	"fmt"
	"github.com/LinMAD/workshops/sybo/storage"
	"log"
	"net/http"
	"regexp"
	"strings"
)

const apiTag = "API: "

type (
	// UUID represents type for unique id
	UUID string
	// API general structure
	API struct {
		// IStorage for data keeping
		Storage storage.IStorage
		Router  *RegexpHandler
	}
	// errorResponse default response
	ErrorResponse struct {
		Message string `json:"error"`
	}
	// successResponse default successful response
	SuccessResponse struct {
		Message string `json:"success"`
	}
)

type route struct {
	pattern *regexp.Regexp
	handler http.Handler
}

// RegexpHandler with routes
type RegexpHandler struct {
	routes []*route
}

// HandleFunc custom handler with url pattern support
func (regHand *RegexpHandler) HandleFunc(pattern string, handler func(http.ResponseWriter, *http.Request)) {
	re := regexp.MustCompile(pattern)

	regHand.routes = append(regHand.routes, &route{re, http.HandlerFunc(handler)})
}

// Serve all HTTP routes
func (regHand *RegexpHandler) ServeHTTP(w http.ResponseWriter, r *http.Request) {
	for _, route := range regHand.routes {
		if route.pattern.MatchString(r.URL.Path) {
			route.handler.ServeHTTP(w, r)
			return
		}
	}

	http.NotFound(w, r)
}

// NewAPI with simple DI
func NewAPI(storage storage.IStorage) *API {
	api := &API{
		Storage: storage,
		Router:  new(RegexpHandler),
	}

	api.registerAllEndpoints()

	return api
}

// registerAllEndpoints handle all registered API endpoints
func (api *API) registerAllEndpoints() {
	api.Router.HandleFunc("^/user$", api.user)
	api.Router.HandleFunc(`^/user/(.*)/state$`, api.gameState)
	api.Router.HandleFunc(`^/user/(.*)/friends$`, api.friend)
}

// errorResponse
func (api *API) errorResponse(w http.ResponseWriter, err error, statusCode ...int) {
	var code int

	if len(statusCode) > 0 {
		code = statusCode[0]
	} else {
		code = http.StatusInternalServerError
	}

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(code)
	errResponse := ErrorResponse{Message: err.Error()}
	json.NewEncoder(w).Encode(errResponse)
}

// successResponse
func (api *API) successResponse(w http.ResponseWriter, code int, payload interface{}) {
	response, err := json.Marshal(payload)
	if err != nil {
		// TODO Use logger from dependencies
		log.Printf("%s API success response dispatch error: %s", apiTag, err.Error())
		api.errorResponse(w, fmt.Errorf("%s", "Unable to dispatch response"))

		return
	}

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(code)
	w.Write(response)
}

// invalidHTTPMethod default error
func (api *API) invalidHTTPMethod(w http.ResponseWriter) {
	api.errorResponse(w, fmt.Errorf("%s", "Invalid request method"), http.StatusMethodNotAllowed)
}

// getUserUUIDFromPath extract uuid from request
func (api *API) getUserUUIDFromPath(r *http.Request) (UUID, error) {
	urlPart := strings.Split(r.URL.Path, "/")
	if len(urlPart) != 4 { // -> /user/{id}/state
		err := fmt.Errorf("%s", "Unexpected err")
		log.Printf("%s Url parsing error: %s", tagGameState, "Expected 3 part of url, returned less")

		return "", err
	}

	return UUID(urlPart[2]), nil
}

// checkIfUserExist
func (api *API) checkIfUserExist(w http.ResponseWriter, r *http.Request) *UUID {
	var requesterUUID UUID
	var uuidErr error

	requesterUUID, uuidErr = api.getUserUUIDFromPath(r)
	if uuidErr != nil {
		api.errorResponse(w, uuidErr, http.StatusServiceUnavailable)

		return nil
	}

	isUser := api.Storage.Get(string(requesterUUID))
	if isUser == nil {
		api.errorResponse(w, fmt.Errorf("%s", "User not found"), http.StatusNotFound)

		return nil
	}

	return &requesterUUID
}
