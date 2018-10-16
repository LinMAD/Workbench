package generator

import "os/exec"

// GenerateUUID
func GenerateUUID() (string, error) {
	newId, err := exec.Command("uuidgen").Output()
	if err != nil {
		return "", err
	}

	return string(newId), nil
}
