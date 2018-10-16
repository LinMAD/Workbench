package api

import (
	"encoding/json"
	"fmt"
	"github.com/LinMAD/workshops/sybo/storage"
	"log"
	"net/http"
	"regexp"
)

const apiTag = "API: "

type (
	// UUID represents type for unique id
	UUID string
	// API general structure
	API struct {
		// Storage for data keeping
		Storage storage.Storage
		Router *RegexpHandler
	}
	// ErrorResponse default response
	ErrorResponse struct {
		Message string `json:"error"`
	}
	// SuccessResponse default successful response
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
func NewAPI(storage storage.Storage) *API {
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
}

// ErrorResponse
func (api *API) ErrorResponse(w http.ResponseWriter, err error, statusCode ...int) {
	var code int

	if len(statusCode) > 0 {
		code = statusCode[0]
	} else {
		code = http.StatusInternalServerError
	}

	w.WriteHeader(code)
	errResponse := ErrorResponse{Message: err.Error()}
	json.NewEncoder(w).Encode(errResponse)
}

// SuccessResponse
func (api *API) SuccessResponse(w http.ResponseWriter, code int, payload interface{}) {
	response, err := json.Marshal(payload)
	if err != nil {
		// TODO Use logger from dependencies
		log.Printf("%s API success response dispatch error: %s", apiTag, err.Error())
		api.ErrorResponse(w, fmt.Errorf("%s", "Unable to dispatch response"))
		return
	}

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(code)
	w.Write(response)
}

// InvalidHTTPMethod default error
func (api *API) InvalidHTTPMethod(w http.ResponseWriter) {
	api.ErrorResponse(w, fmt.Errorf("%s", "Invalid request method"), http.StatusMethodNotAllowed)
}