package generator

import (
	"os/exec"
	"strings"
)

// GenerateUUID
func GenerateUUID() (string, error) {
	newId, err := exec.Command("uuidgen").Output()
	if err != nil {
		return "", err
	}

	cleanId := strings.TrimSuffix(string(newId), "\n")

	return string(cleanId), nil
}
