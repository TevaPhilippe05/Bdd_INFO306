#Changment de mdp
 curl -X 'PUT' 'http://152.228.214.245/info306/info_gr4/learners/1'\
  -H 'accept: */*'\
  -H 'Content-Type: application/x-www-form-urlencoded'\
  -d 'password=ya'

# Changement d'état
curl -X 'PUT' 'http://152.228.214.245/info306/info_gr4/learners/1/state' \
  -H 'accept: */*' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -d 'state_id=2'

# Connection
curl -X 'POST' \
  'http://152.228.214.245/info306/info_gr4/learners' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -d 'mail=yo&password=ya'

# Retourne un etdudiant par son id
curl -X 'GET' \
  'http://152.228.214.245/info306/info_gr4/learners/1' \
  -H 'accept: application/json'

# Get teams
curl -X 'GET' \
  'http://152.228.214.245/info306/info_gr4/teams/1' \
  -H 'accept: application/json'
