# caMicroscope Security and Router Container
TODO

## Configuration

routes.json

### Variables
{IN}
{OUT}
{USER}
{NOW}

### Resolvers
source - the pattern to ger {IN} from
destination - what to use as the method url, after {OUT} substitution,
url - the url to check
field - the field in the response to assign to {OUT}
before - a string or list of strings to get the variable before; if multiple match, the first match is used
after - a string or list of strings to get the variable after; if multiple match, the first match is used

### Keycheck
!!!! Keycheck is not yet implemented, but part of a potential concept for later

Checks if a named field is present in both the users permissions and the document
If passIfMissing is truthy, it will return a document with no such field
