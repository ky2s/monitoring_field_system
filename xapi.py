from flask import Flask
from flask_restful import reqparse, abort, Api, Resource
from flask import request
import requests
import commands

app = Flask(__name__)
api = Api(app)

parser = reqparse.RequestParser()
parser.add_argument('formID')
parser.add_argument('userID')
parser.add_argument('timeStamp')
parser.add_argument('latitude')
parser.add_argument('longtitude')
parser.add_argument('jawaban')
parser.add_argument('pertanyaanId')
parser.add_argument('IMEI')
parser.add_argument('IMEI_MD5')
parser.add_argument('formid')
parser.add_argument('userid')
parser.add_argument('email')
parser.add_argument('password')
parser.add_argument('userId')

parser.add_argument('userId')
parser.add_argument('formDetailId')


class FormList(Resource):
	"""docstring for ClassName"""
	def post(self):
		args = parser.parse_args()
		data = [
				  ('userid', args['userid']),
				]
		r = requests.post('http://localhost:8009/api/user/form', data=request.form)
		return r.json()

class FormDetail(Resource):
	"""docstring for ClassName"""
	def post(self):
		args = parser.parse_args()
		data = [
				  ('formid', args['formid']),
				]
		r = requests.post('http://localhost:8009/api/user/form/detail', data=request.form)
		return r.json()

class SaveForm(Resource):
	"""docstring for ClassName"""
	def post(self):
		args = parser.parse_args()
		data = [
				  ('formID', args['formID']),
				  ('userID', args['userID']),
				  ('timeStamp', args['timeStamp']),
				  ('latitude', args['latitude']),
				  ('longtitude', args['longtitude']),
				  ('jawaban', args['jawaban']),
				  ('pertanyaanId', args['pertanyaanId']),
				  ('IMEI', args['IMEI']),
				  ('IMEI_MD5', args['IMEI_MD5']),
				]
		r = requests.post('http://localhost:8009/api/user/form/save', data=request.form)
		# print request.form
		return r.json()

class UserLogin(Resource):
	"""docstring for ClassName"""
	def post(self):
		args = parser.parse_args()
		data = [
				  ('email', args['email']),
				  ('password', args['password']),
				]
		r = requests.post('http://localhost:8009/api/user/login', data=data)
		return r.json()

class SaveImageForm(Resource):
	"""docstring for ClassName"""
	def post(self):
		args = parser.parse_args()
		data = [
				  ('userId', args['userId']),
				  ('formDetailId', args['formDetailId']),
				  ('jawaban', args['jawaban']),
				  ('IMEI', args['IMEI']),
				]
		r = requests.post('http://localhost:8009/api/user/form/saveimageform', data=data)
		return r.json()

##
## Actually setup the Api resource routing here
##
api.add_resource(UserLogin, '/api/user/login')
api.add_resource(FormList, '/api/user/form')
api.add_resource(FormDetail, '/api/user/form/detail')
api.add_resource(SaveForm, '/api/user/form/save')
api.add_resource(SaveImageForm, '/api/user/form/saveimageform')

if __name__ == '__main__':
	app.run(host='0.0.0.0', port=5001)
