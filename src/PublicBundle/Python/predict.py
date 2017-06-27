import cv2
import numpy as np
import urllib2
import json

def image_dimensions():
	# Masquerade as Mozilla because some web servers may not like python bots.
	hdr = {'User-Agent': 'Mozilla/5.0'}
	# Set up the request
	req = urllib2.Request(request.vars.url, headers=hdr)
	try:
		# Obtain the content of the url
		con = urllib2.urlopen( req )
		# Read the content and convert it into an numpy array
		im_array = np.asarray(bytearray(con.read()), dtype=np.uint8)
		# Convert the numpy array into an image.
		im =  cv2.imdecode(im_array, cv2.IMREAD_GRAYSCALE)
		# Get the width and heigh of the image.
		height, width = im.shape
		# Wrap up the width and height in an object and return the encoded JSON.
		return json.dumps({"width" : width, "height" : height})

	except urllib2.HTTPError:
		return urllib2.HTTPError.fp.read()

