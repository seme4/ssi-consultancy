# sameAs Lite Concepts

Equivalent URIs are conceptually stored in a *bundle*. A bundle is a set of URIs referring to resources which are considered to be equivalent, in a given context. A URI can exist in at most one bundle within a linked data set exposed by a sameAs Lite instance.

One URI in each bundle is nominated to be a canonical identifier, or *canon*, for that bundle. The canon represents a *preferred URI* for the set of duplicates. 

An application that wishes to use data from multiple sources as if they were a single resource can process results by looking up URIs within sameAs Lite and replacing these with their canons on the fly. This reduces the multiplicity of identifiers to a single definitive URI.

For more information about the concepts underpinning sameAs Lite, see Glaser, H., Jaffri, A. and Millard, I. C. (2009) [Managing Co-reference on the Semantic Web](http://eprints.soton.ac.uk/267587/). In: Linked Data on the Web (LDOW2009), April 2009, Madrid, Spain.

---

## Database schema

sameAs Lite stores equivalent URIs within a single database table which associates an URI with its canon. The schema of this table is as follows:

For MySQL:

    +--------+--------------+------+-----+---------+-------+
    | Field  | Type         | Null | Key | Default | Extra |
    +--------+--------------+------+-----+---------+-------+
    | canon  | varchar(256) | YES  | MUL | NULL    |       |
    | symbol | varchar(256) | NO   | PRI |         |       |
    +--------+--------------+------+-----+---------+-------+

For SQLite:

    +--------+------+-----+
    | Field  | Type | Key |
    +--------+------+-----+
    | canon  | TEXT |     |
    | symbol | TEXT | PRI |
    +--------+---- -+-----+

A database index is created on canon.
