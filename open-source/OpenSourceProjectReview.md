# Open Source Project Review

Mike Jackson, The Software Sustainability Institute / EPCC, The University of Edinburgh

## Introduction

[sameAs.org](http://sameas.org) is a search engine for linked data that, if given a URI, returns URIs that are co-referent, should any be known to it. The engine searches information harvested from a number of sources. 

sameAs.org was originally developed by Hugh Glaser and Ian Millard, formerly of the University of Southampton, and now at [Seme4 Limited](http://www.seme4.com). sameAs.org has been live since 2009.

Apart from its own data stores, sameAs.org also hosts linked data stores for a number of organisations, including Freebase (which helps power Google Knowledge Graph), the British Library, other national libraries including those of Spain, France, Norway, Germany and Hungary, VIAF (Virtual International Authority File), and the Ordnance Survey. 

Many of these organisations may want to run their own data stores and Seme4 would like to help them do this. To this end, Seme4 has produced [sameAs Lite](http://github.com/seme4/sameas-lite), a refactored, free open source, version of the software that powers sameAs.org.

The report discusses issues in how Seme4 can promote community engagement around sameAs Lite. This is focused around two aspects:

* Setting up the infrastructure, or resources, that are required by open source projects.
* Setting up the policies and processes by which an open source project is run.

### Format

Section headings are task-oriented so they can serve as a check-list of issues to be addressed.

### Supplementary documents

There are five supplementary documents for this report:

* [Seme4 Individual Contributor Licence Agreement (draft)](./Seme4-CLA-Individual.doc).
* [Seme4 Software Grant and Corporate Contributor Licence Agreement (draft)](./Seme4-CLA-Corporate.doc).
* [sameAs Lite Governance Model (draft)](./GovernanceModel.md).
* [How to Get Help (draft)](./HowToGetHelp.md).
* [Get in Touch (draft)](./GetInTouch.md).

---

## Infrastructure

The UK's open source advisory body, [OSS Watch](http://oss-watch.ac.uk/), recommend the following [four resources](http://oss-watch.ac.uk/resources/communitytools) for community engagement with an open source project. These, and their uses are as follows:

* A web site for publicising the product, and providing a first port of call for users and developers.
* One or more mailing lists, to allow developers to exchange ideas, design and development information and discuss all aspects of the project and to allow users to request help and share experiences. Ideally, these should be archived and publicly searchable as such archives can serve as additional help and support resources for both users and developers. A common set of lists is one for users, one for developers, and one for announcements (e.g. of new releases).
* A source code repository for code management.
* An issue tracker, for the planning and management of feature requests, bug fixes and other development activities.

For sameAs Lite there already exists:

* A web site, http://www.seme4.com/, which summarises Seme4's technologies, clients and case-studies. sameAs Lite is linked from the [sameAs projects](http://www.seme4.com/projects/sameas/) page.
* A publicly-visible source code repository, Git, hosted on GitHub, https://github.com/seme4/sameas-lite.
* A publicly-visible issue tracker, associated with the above repository on GitHub, https://github.com/seme4/sameas-lite/issues.

What remains to be provided is one or more mailing lists. At present, there are only two e-mail addresses, contact@sameas.org and contact@seme4.com.

### Choose a mailing list provider

There are many options available. Popular providers include the following, which all support publicly-searchable archives:

* [GoogleGroups](https://groups.google.com). Technically these are forums but posts can be automatically e-mailed to members so they behave like mailing lists.
* [Yahoo Groups](http://uk.groups.yahoo.com).
* [JISCMail](http://www.jiscmail.ac.uk/about). For the UK academic community. One condition is that lists should support learning, teaching, research or professional support activities across UK education and research, that at least 25% of the subscribers should be from UK Higher Education, Further Education Institutions, Research Communities, Educational Support Organisations or JISC funded projects and services and that the primary list owner is employed by one of these organisations.

### Add a README.md to the repository

A README.md should be added to the repository as this will often be the first document read when someone visits the repository on GitHub. Opinion can vary on what they should contain (see, for example, [How to write a good README](http://stackoverflow.com/questions/2304863/how-to-write-a-good-readme) on StackOverflow). I'm inclined towards providing a short summary of essential information, with links to other information e.g.

* A short summary of sameAs Lite and what it is designed to do, with links to:
  - http://www.seme4.com
  - http://www.seme4.com/projects/sameas
  - http://sameas.org
* Copyright and licence.
* Links to further information e.g. 
  - User documentation (configuration/installation/operation).
  - How to get in touch.
  - How to get help.
  - Developer documentation.
  - Open source project documentation.
  - Credits and acknowledgements
  - etc.
* Contact information:
  - Mailing list.
  - Issue tracker.

### Add a Seme4 logo

GitHub allows organisations, such as that for [Seme4](https://github.com/seme4), to have an associated logo. Add the Seme4 company logo here to reinforce the link with Seme4.

### Create a sameAs Lite logo

Likewise, it is common for software to have logos. Consider whether to adopt the sameAs.org service logo, `<sameAs>`, or a variant of it, for sameAs Lite, to help reinforce the identity of the software. This, in future, provides the opportunity to ask users and developers building services that are underpinned by sameAs Lite to add 'Powered by sameAs Lite' to their services.

### Choose where to host sameAs Lite user and developer documentation

sameAs Lite will have user, developer and open source project documentation (see below). It would feel out of tone with the Seme4 web site to host it there, so an alternative host should be considered.

Many options are possible both for managing the content and for hosting the web server that exposes this content. GitHub supports both of these via its repository-specific wikis and [gh-pages](http://pages.github.com/) functionality, so these, and other options I've experience of, are summarised:

| Pros | Cons |
| ---- | ---- |
| **GitHub repository and MarkDown pages** | |
| Edit pages as raw [GitHub-flavoured MarkDown](https://help.github.com/articles/github-flavored-markdown/) | Need a viewer to see how they render |
| Raw MarkDown is human-readable | |
| Manage pages using Git | Need to use Git |
| GitHub renders GitHub-flavoured MarkDown | Can only browse pages online |
| Supports embedded images | |
| | |
| **GitHub wiki and MarkDown pages** | |
| Edit pages as raw GitHub-flavoured markdown locally or within web browser | |
| Web browser editor has Preview option | |
| Raw MarkDown is human-readable | |
| Manages versioning automatically | |
| Held within a Git repository behind the scenes which can be used directly (see [adding and editing wiki pages locally](https://help.github.com/articles/adding-and-editing-wiki-pages-locally/) | |
| GitHub renders GitHub-flavoured MarkDown | Can only browse pages online |
| Supports embedded images (see [adding images to wikis](https://help.github.com/articles/adding-images-to-wikis/)) | Image links need to be absolute URLs to images hosted in another repository |
| | Wikis can evolve haphazardly and quickly become confusing |
| | |
| **GitHub [gh-pages](http://pages.github.com/) and [Jekyll](http://jekyllrb.com/)** | |
| Edit pages as raw GitHub-flavoured MarkDown and/or HTML | |
| Raw MarkDown is human-readable | |
| Manage pages using Git | Need to use Git |
| GitHub automatically converts into a web site ([example](http://apawlik.github.io/2014-11-27-elixiruk-manchester/)) | |
| Browse pages locally | Need to have Jekyll locally installed |
| Install tools GitHub uses to create local copy of the pages which can be shipped to users/developers for offline browsing | |
| Supports embedded images | |
| | |
| **[DocBook](http://www.docbook.org/) mark-up language for technical documentation** | |
| Edit pages as XML | Far more verbose, and less human-readable, than MarkDown |
| Manage pages using revision control (optional but, as for all raw sources, recommended) | |
| DocBook compiles XML into PDF, HTML, Microsoft Compiled HTML Help | |
| Supports embedded images, tables of contents, indexes, cross-references, conditional content | |
| Powerful | Complex |
| | Need a web server for publication |
| | |
| **Raw HTML** | |
| | Far more verbose, and less human-readable, than MarkDown |
| Manage pages using revision control (optional but, as for all raw sources, recommended) | |
| Supports embedded images | Implement tables of contents, indexes, cross-references, conditional content manually |
| Many HTML-to-PDF convertors available (e.g. [Prince](http://www.princexml.com/) which is free for non-commercial use) | |
| | Need a web server for publication |
| | |
| **Content Management System** (e.g. [Drupal](http://www.drupal.org), [Joomla](http://www.joomla.org), [Wordpress](http://www.wordpress.org/)) | |
| Web browser [WYSIWYG](http://en.wikipedia.org/wiki/WYSIWYG) editor | |
| No need to write HTML or MarkDown | |
| Third-parties can be given accounts | |
| No need to pull content or rebuild web site | |
| | Need to install and maintain CMS and back-end database |

For a comparison between Drupa, Joomla and Wordpress see [CMS Comparison: Drupal, Joomla and Wordpress](http://www.rackspace.com/knowledge_center/article/cms-comparison-drupal-joomla-and-wordpress).

Holding pages under revision control, within a wiki, or within a CMS all support page versioning and maintaining an audit trail of who changed what, when and why. However, one challenge is keeping user and developer documentation in-synch with the source code. All to often, it can be unclear to which version of some software, a wiki page or web page refers to. Some projects, for example [Software Carpentry](http://software-carpentry.org/), avoid the use of wikis, preferring to keep everything as pages under revision control.

Of the above options then, I'd be most inclined to recommend, at least at the outset, and if writing documentation in MarkDown is not too onerous, one of using either a GitHub repository and MarkDown pages or gh-pages as:

* Pages are held under revision control.
* Updates to multiple pages can be the subject of a single commit (unlike in a CMS where change tracking is limited to individual pages).
* Source code and documentation can be kept in-synch via the use of consistent tags across their repositories.
* GitHub automatically renders the content so it is browsable online.
* Raw MarkDown is human-readable.

### Add a 'Get in Touch' page

It is essential for both users and developers to know how to get in touch, and that this information is easily accessible. Provide a single Get in Touch page which summarise what resources should be used for what sort of contact. An example page is at:

* [Get in Touch (draft)](./GetInTouch.md).

The draft is incomplete since some content depends upon the mailing list to be adopted.

### Add a 'How to Get Help' page

To get help, users and developers will use one of the avenues in the previous section. There are also a number of other sources of information they can consult. Provide a single page which describes how users and developers can help themselves, and help you to help them. An example page is at:

* [How to Get Help (draft)](./HowToGetHelp.md).

The draft is incomplete since some content depends upon the mailing list to be adopted.

For developers, within the 'how to ask for help' section, another option is a link to Eric Steven Raymond and Rick Moen's guide on [How to ask questions the smart way](http://www.catb.org/esr/faqs/smart-questions.html), but this endorses RTFM which I'm not keen on.

---

## Policies and processes

In addition to resources, an open source project needs policies and processes specifying how those resources are used and how the open source project is managed.

### Choose a process for using the source code repository

A process for using the repository needs to be decided upon e.g. where does the development of bug fixes and features take place in the repository, how are bugs identified in a released version managed etc. One [common approach](http://nvie.com/posts/a-successful-git-branching-model), which, from experience, I'd recommend, is a number of branches:

* master branch with the current version of sameAs Lite. When stable the changes are reviewed and merged into a release branch by one of a select group of committers.
* release branch with the current version of sameAs Lite for release. When a release is done, the state of this branch is tagged (e.g. sameAs-Lite-1.2.3).
* feature branches with work done on implementing a specific feature. These are branches of the master branch. When stable these are merged back into the master branch by one of a select group of committers.
* bug fix branches with work done on implementing a specific bug fix. These are branches of either the master branch, or, for bug fixes identified in a specific release, the corresponding release branch. When stable these are merged back into the original branch as well as, for release branches, the master branch by one of a select group of committers.

Tags are used for releases, and any other milestone of note. If a bug is found in a release, and needs fixed, then the appropriate tag is branched into a new bug fix branch.

This allows bug fixes to released versions to be quickly implemented without telling users to wait for the next major release, which may be some time away. It also avoids a problem that can arise if everyone works on exactly the same trunk or branch whereby a developer commit changes that breaks the build and then goes on leave for a fortnight.

As Git is a distributed source code repository, each developer can use their own repository for their development, and do what they want with this. How their changes are transferred into the canonical repository becomes a process issue. Two options are:

* A developer asks a committer with access to master to pull in their changes. This committer can pull in their changes into a new branch in the canonical repository until such time as they are ready to merge it into the master branch.
* A developer pulls in their own changes, initially into a new branch in the canonical repository (named according to an agreed naming scheme e.g. mike-jackson-featureX) until such time as they are ready to be merged by a committer with access to the master branch. GitHub does not support access-control to individual branches so this relies on trusting developers to follow the process (but as it's all under revision control nothing is lost and the guilty can be identified).

### Replace MIT Public License with another free, open source licence

sameAs Lite is freely available under the free, open source, OSI-approved [MIT Public License](http://opensource.org/licenses/MIT). However, in a [comment](http://www.software.ac.uk/blog/2013-07-31-should-we-be-scared-choosing-oss-licence#comment-5858) on an Institute blog post [Should we be scared of choosing an OSS licence?](http://www.software.ac.uk/blog/2013-07-31-should-we-be-scared-choosing-oss-licence), Chris Morris of STFC observed that:

> Github's advice is not good for UK residents, because the repudiation of liability in the MIT license is not valid in UK law. The reason for this is: 
>
> * in UK law you cannot reject liability for personal injury or death 
> * when part of a sentence in a contract is invalid, the contract is considered as if the sentence as a whole was omitted 
> * after you strike out the inapplicable sentence, the MIT licence contains no statement about liability 

This seems to arise from the MIT Public License text which comments:

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.

Moving to another free, open source, OSI-approved licence, e.g. [GNU General Public License 3](http://www.gnu.org/copyleft/gpl.html) would provide similar licence conditions to the MIT Public License, but provides a limitation of liability which factors in local laws ("UNLESS REQUIRED BY APPLICABLE LAW"):

    16. Limitation of Liability.
    IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN
    WRITING WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES
    AND/OR CONVEYS THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR
    DAMAGES, INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL
    DAMAGES ARISING OUT OF THE USE OR INABILITY TO USE THE PROGRAM
    (INCLUDING BUT NOT LIMITED TO LOSS OF DATA OR DATA BEING RENDERED
    INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD PARTIES OR A FAILURE OF
    THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS), EVEN IF SUCH HOLDER
    OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. 

### Consider dual licencing

As the copyright holders, you can licence sameAs Lite in as many was as you want. You may want to consider [dual licencing](http://oss-watch.ac.uk/resources/duallicence) where, for example, software can be freely released under GPL, requiring anyone who modifies it to release their modifications. For those wishing to make money from selling closed source modifications, a proprietary licence can be offered in which they are allowed to make closed source modifications but with yourselves being reimbursed in some way.

### Publish coding standards

Coding standards are useful because they can help ensure that source code is readable. Readable code is useful not only for the original developer if they need to modify or extend their code at a later date, but also for other developers who wish to modify or extend the code. Coding standards are valuable in collaborative projects as they recognise that the code belongs to the project as a whole, not any individual developer, and a common look-and-feel to the code helps foster collective ownership and the idea that any developer can work on any part of the code. For more on readable source code see The Software Sustainability Institute's guide on [Writing readable source code](http://software.ac.uk/resources/guides/writing-readable-source-code).

sameAs Lite already has support in place for checking conformance to coding standards in the [dev-tools/CodeStandard](https://github.com/seme4/sameas-lite/tree/master/dev-tools/CodeStandard) directory, but there is no human-readable form of the coding standards.

### Define a governance model

A [governance model](http://oss-watch.ac.uk/resources/governancemodels) sets out how an open source project is run. Specifically it sets out:

* The roles within the project's community and the responsibilities associated with each role.
* How the project supports the community.
* What contributions can be made to the project, how they are made, any conditions the contributions must conform to, who retains copyright of the contributions and the process followed by the project in accepting the contribution.
* The decision-making process in within the project.

OSS Watch comment that 'it is never too soon to define a suitable governance model' and that '[w]ithout one, the chances of third parties wishing to contribute are considerably reduced', not least because a project 'will not look serious about engaging with third parties'.

Given that sameAs Lite is a new open source project, a [benevolent dictatorship model](http://oss-watch.ac.uk/resources/benevolentdictatorgovernancemodel) is recommended where control of the project remains with the original sameAs Lite developers. There is no reason why this cannot change at a later date. 

With this in mind, and considering the three potential classes of sameAs Lite stakeholder:

* Users deploying sameAs Lite.
* Developers interested in designing/developing sameAs Lite.
* Developers interested in integrating sameAs Lite components within other software.

a draft governance model is at:

* [sameAs Lite Governance Model (draft)](./GovernanceModel.md).

This is based on the content recommended by OSS Watch for a benevolent dictator governance model and the governance model of the OGSA-DAI project, which, in turn, was based on that of [Taverna](http://www.taverna.org.uk/about/legal-stuff/taverna-governance-model). Institute staff worked upon these projects for many years.

The model is incomplete since some content depends upon the mailing list to be adopted. It also refers to the MIT Public License.

### Define contributor licence agreements

The proposed governance model requires contributors to complete [contributor licence agreements](http://oss-watch.ac.uk/resources/cla) (CLAs) for code contributions. These provide a record that an author has given granted an individual or group the right to redistribute their work and under the terms and conditions of any licence that the individual or group are using for their software. Individual CLAs can be used if the individual is the sole copyright owner of their contribution and corporate CLAs can be used if their employer owns copyright on their work. Many projects e.g. [Apache](http://www.apache.org/licenses/#clas), [Eclipse](http://wiki.eclipse.org/Development_Resources/Contributing_via_Git) and [Google](https://developers.google.com/open-source/cla/individual) use CLAs. 

Drafts of individual and corporate CLAs for LabBook are at:

* [Seme4 Individual Contributor License Agreement (draft)](./Seme4-CLA-Individual.doc).
* [Seme4 Software Grant and Corporate Contributor License Agreement (draft)](./Seme4-CLA-Corporate.doc).

These are based on those for OGSA-DAI, devised by EPCC, The University of Edinburgh, and are analogous to those for Apache.

### Encourage contributions

To encourage contributions, the contributions policy section of the governance model can be pulled out and published explicitly on a project resource, for example, as part of a 'Get involved' page on the web site.

### Ensure that more than one team member can monitor e-mails

There are two e-mail addresses, contact@seme4.com and contact@sameas.org, which users can currently use. More than one team member should have access to these. Likewise, more than one team member should have access to any mailing list and this should be monitored.

This can help to ensure that e-mails are replied to in a timely manner. A user can be deterred from using software further, or a potential user might look elsewhere, if they get no reply to an e-mail. In the worst case this can lead to bad word-of-mouth to others. 

### Define a support policy

'How to Get Help' represents a support policy. This can be extended with information on when users can expect a response e.g. 'we aim to reply to all e-mails within 1 week'. Two important points to keep in mind are that:

* Responding to an e-mail or GitHub ticket ensures the user does not feel ignored, which can be an issue as mentioned above. 
* Responding to a user request does not imply fixing a bug or implementing a feature, it merely acknowledges that you've heard them. No-one has a right to **expect** support for free software.

As some users are reluctant to use issue trackers, users can be told to submit all feature requests and bug reports go via the mailing list. For these, a team member can then raise a ticket. You can never 100% stop users e-mailing individual members of the team. However, any users that contact individual team members can politely be requested to resubmit their request to your mailing list. Such requests to users can point out that others may be interested in the request (or may be stuck with the same bug) and may be interested in the answer. If a user really wants/needs help they will do this. Or, for a first-timer, you can send their e-mail and your reply to the mailing list yourself. If they reply to you personally, remember to CC the mailing list in your reply. For the OGSA-DAI project, we found that this approach to be the least painful.

For more information, see the Institute guide on [Supporting open-source software](http://software.ac.uk/resources/guides/supporting-open-source-software).

### Define a release process

A release process for sameAs Lite should be defined. This should include:

* How to build a release and any preconditions for doing so.
* How to test a release.
* What documentation needs to be updated.
* How to release the release bundle e.g. upload to GitHub.
* How to test the uploaded bundle.
* How to create a tag under Git to ensure the code used to create that release is preserved.

### Publish processes and policies

Publish all policies and processes on a project resource e.g. wiki or web site.

---

## Review your openness

OSS Watch developed an Openness Rating tool to support their consultancy and have used it in-house for years. This is now freely available to use [online](http://oss-watch.ac.uk/apps/openness). The tool asks users to answer questions, grouped into 5 categories: Legal Issues, Data Formats and Standards, Knowledge, Governance, and Market. The questions can provide further insight into how to engage with users and developers and further improve openness. Answers are weighted and are used to calculate an "openness rating" percentage for each of the categories. The ratings are presented as a web page. 

---

## Guides on building open source communities

You may find the following resources useful for building an open source community:

* [How To Build An Open Source Community](http://oss-watch.ac.uk/resources/howtobuildcommunity), OSS Watch.
* [Recruiting champions for your project](http://software.ac.uk/resources/guides/recruiting-champions-your-project), The Software Sustainability Institute
* [Top tips for expanding your user community](http://www.software.ac.uk/blog/2013-10-29-top-tips-expanding-your-user-community), The Software Sustainability Institute
